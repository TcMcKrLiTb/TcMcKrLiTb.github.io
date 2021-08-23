<?php
/**
 * @author Jesus Macias <jesus@owncloud.com>
 *
 * @copyright Copyright (c) 2016, ownCloud, Inc.
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OCA\windows_network_drive\lib;

use Icewind\SMB\Exception\ForbiddenException;
use OCA\Files_External\Lib\Storage\SMB;
use OCP\Files\StorageNotAvailableException;
use OCA\windows_network_drive\lib\acl\permissionmanager\PermissionManagerFactory;
use OCA\windows_network_drive\lib\acl\permissionmanager\PermissionManagerException;
use OCP\IUser;

/**
 * FS class to connect to windows network drives
 */
class WND extends SMB {
	protected $isInitialized = false;
	protected $shareName;
	protected $host;
	protected $domain = '';
	protected $user;
	protected $password;
	protected $permissionManagerName = '';

	/** @var array<string, IUser[]> */
	protected $mountsWithUsers = [];

	protected $wndNotifier;
	protected $permissionManager;

	protected $cachedAclPermissions = [];

	public function __construct($params) {
		parent::__construct($params);

		$this->domain = $params['domain'];
		$this->user = $params['user'];
		$this->password = $params['password'];
		$this->shareName = $params['share'];
		$this->host = $params['host'];

		// register in the singleton notifier
		if (\OC::$server->getConfig()->getSystemValue('wnd.in_memory_notifier.enable', true) === true) {
			$this->wndNotifier = WNDNotifier::getSingleton();
			$this->wndNotifier->registerWND($this);
		}

		$factory = new PermissionManagerFactory();
		$factoryParameters = [
			'host' => $this->host,
			'share' => $this->shareName,
			'domain' => $this->domain,
			'user' => $this->user,
			'password' => $this->password,
		];

		if (isset($params['permissionManager'])) {
			$this->permissionManagerName = $params['permissionManager'];
		}
		$this->permissionManager = $factory->createPermissionManagerByName($this->permissionManagerName, $factoryParameters);
	}

	public function init() {
		if ($this->isInitialized) {
			return;
		}

		$this->validateConfiguration();

		try {
			$this->connectionTestWithReset();
		} catch (ForbiddenException $e) {
			throw new StorageNotAvailableException('Storage not available, perhaps outdated credentials.');
		}
		$this->isInitialized = true;
	}

	/**
	 * Get the username's domain trying to access to the windows drive. It might be different than the
	 * current ownCloud user. Note that the domain won't be extracted from the username (in case a username
	 * such as "mydomain\myusername" is used). The domain must be supplied as an additional parameter.
	 *
	 * @return string the domain
	 */
	public function getDomain() {
		$this->log('getDomain: '.$this->domain, \OCP\Util::DEBUG);
		return $this->domain;
	}

	/**
	 * Get the username trying to access to the windows drive. It might be different than the
	 * current ownCloud user
	 *
	 * @return string the username
	 */
	public function getUser() {
		$this->log('getUser: '.$this->user, \OCP\Util::DEBUG);
		return $this->user;
	}

	/**
	 * Get the host we're trying to access
	 *
	 * @return string the host
	 */
	public function getHost() {
		$this->log('getHost: '.$this->host, \OCP\Util::DEBUG);
		return $this->host;
	}

	/**
	 * Get the sharename where we're trying to access
	 *
	 * @return string the share name
	 */
	public function getShareName() {
		$this->log('getShareName: '.$this->shareName, \OCP\Util::DEBUG);
		return $this->shareName;
	}

	/**
	 * Get the folder that will act as our root
	 *
	 * @return string the root folder
	 */
	public function getRoot() {
		$this->log('getRoot: '.$this->root, \OCP\Util::DEBUG);
		return $this->root;
	}

	public function getPassword() {
		$this->log('getPassword: (fetched)', \OCP\Util::DEBUG);
		return $this->password;
	}

	/**
	 * Get the name of the permissions manager used by this instance. Note that the
	 * actual object won't be returned, just the name
	 */
	public function getPermissionManagerName() {
		$this->log('getPermissionManagerName: ' . $this->permissionManagerName, \OCP\Util::DEBUG);
		return $this->permissionManagerName;
	}

	/**
	 * Get the FS id (for ownCloud purposes). Method overloaded to keep retrocompatibility.
	 *
	 * @return string the FS id
	 */
	public function getId(): string {
		$username = Utils::conditionalDomainPlusUsername($this->getDomain(), $this->getUser());
		$id = 'wnd::' . $username . '@' . $this->getHost() . '/' . $this->getShareName() . '/' . $this->getRoot();
		$this->log('getId id: '.$id, \OCP\Util::DEBUG);
		return $id;
	}

	/**
	 * @param string $message
	 */
	private function log($message, $level, $from='wnd') {
		if (\OC::$server->getConfig()->getSystemValue('wnd.logging.enable', false) === true) {
			\OCP\Util::writeLog($from, $message, $level);
		}
	}

	protected function getFileInfo($path) {
		$this->init();
		return parent::getFileInfo($path);
	}

	protected function getFolderContents($path) {
		$this->init();
		return parent::getFolderContents($path);
	}

	public function unlink($path) {
		$this->init();
		return parent::unlink($path);
	}

	public function fopen($path, $mode) {
		$this->init();
		return parent::fopen($path, $mode);
	}

	public function rmdir($path) {
		$this->init();
		return parent::rmdir($path);
	}

	public function mkdir($path) {
		$this->init();
		return parent::mkdir($path);
	}

	public function touch($path, $time=null) {
		$this->init();
		return parent::touch($path, $time);
	}

	private function getAclPermissions($path) {
		if (isset($this->cachedAclPermissions[$path])) {
			return $this->cachedAclPermissions[$path];
		}

		// we'll cache only one item, mainly for consecutive "isReadable" + "isUpdateable"...
		$this->cachedAclPermissions = [];

		try {
			$this->cachedAclPermissions[$path] = $this->permissionManager->getACLPermissions(
				Utils::conditionalDomainPlusUsername($this->domain, $this->user),
				$this->buildPath($path)
			);
		} catch (PermissionManagerException $ex) {
			throw new StorageNotAvailableException("ACL couldn't be fetched: ". $ex->getMessage(), 0, $ex);
		}
		return $this->cachedAclPermissions[$path];
	}

	public function isReadable($path) {
		$isReadable = parent::isReadable($path);
		$aclPermissions = $this->getAclPermissions($path);
		//$aclPermissions = $this->permissionManager->getACLPermissions($this->user, $this->buildPath($path));
		if ($aclPermissions === false) {
			// no ACL info provided
			return $isReadable;
		} else {
			// aclPermissions['read'] might be:
			// * true if the user is allowed to read
			// * false if the user is EXPLICITLY denied to read
			// * null if the user isn't present in the ACL, usually meaning an implicit deny
			return $isReadable && ($aclPermissions['read'] === true);
		}
	}

	public function isUpdatable($path) {
		$isUpdatable = parent::isUpdatable($path);
		$aclPermissions = $this->getAclPermissions($path);
		//$aclPermissions = $this->permissionManager->getACLPermissions($this->user, $this->buildPath($path));
		if ($aclPermissions === false) {
			// no ACL info provided
			return $isUpdatable;
		} else {
			// aclPermissions['write'] might be:
			// * true if the user is allowed to write
			// * false if the user is EXPLICITLY denied to write
			// * null if the user isn't present in the ACL, usually meaning an implicit deny
			return $isUpdatable && ($aclPermissions['write'] === true);
		}
	}

	public function isDeletable($path) {
		$isDeletable = parent::isDeletable($path);
		$aclPermissions = $this->getAclPermissions($path);
		//$aclPermissions = $this->permissionManager->getACLPermissions($this->user, $this->buildPath($path));
		if ($aclPermissions === false) {
			// no ACL info provided
			return $isDeletable;
		} else {
			// aclPermissions['delete'] might be:
			// * true if the user is allowed to delete
			// * false if the user is EXPLICITLY denied to delete
			// * null if the user isn't present in the ACL, usually meaning an implicit deny
			return $isDeletable && ($aclPermissions['delete'] === true);
		}
	}

	/**
	 * Need direct access to the share because the default function will provoke infinite recursion
	 * in this particular case
	 */
	public function test($personal = false, $testOnly = false) {
		$this->validateConfiguration();

		if ($testOnly) {
			return $this->connectionTestWithoutReset();
		}
		return $this->connectionTestWithReset();
	}

	/**
	 * Test the connection without resetting the password
	 */
	private function connectionTestWithoutReset() {
		$info = $this->share->stat($this->buildPath(''));
		$skipCheckForHidden = \OC::$server->getConfig()->getSystemValue('wnd.storage.testForHiddenMount', true) === false;
		if (!$skipCheckForHidden && $info->isHidden()) {
			throw new \Icewind\SMB\Exception\ConnectException('Cannot connect to storage because the root folder is hidden');
		}
		return true;
	}

	/**
	 * Test the connection and reset the password if needed
	 */
	private function connectionTestWithReset() {
		try {
			$info = $this->share->stat($this->buildPath(''));
			$skipCheckForHidden = \OC::$server->getConfig()->getSystemValue('wnd.storage.testForHiddenMount', true) === false;
			if (!$skipCheckForHidden && $info->isHidden()) {
				throw new \Icewind\SMB\Exception\ConnectException('Cannot connect to storage because the root folder is hidden');
			}
			return true;
		} catch (ForbiddenException $e) {
			if ($this->password !== '') {
				// FIXME: We need credential information to skip the password reset if login credentials
				// are used or make sure login credentials are reset too
				Utils::resetPassword($this);
				// notify all WND objects to reset the password if needed
				// this object will also be notified
				$this->wndNotifier->notifyChange($this, WNDNotifier::NOTIFY_PASSWORD_REMOVAL);
			}
			throw $e;
		}
	}

	/**
	 * receive notification from a WND object. This might remove the current password if host and
	 * user are the same
	 */
	public function receiveNotificationFrom(WND $other, $changeType) {
		$this->log('notification from ' . $other->getHost() . ' ' . $other->getUser() .' to ' . $this->getHost() . ' ' . $this->getUser(), \OCP\Util::WARN);
		if ($changeType === WNDNotifier::NOTIFY_PASSWORD_REMOVAL &&
				$this->getHost() === $other->getHost() &&
				$this->getUser() === $other->getUser()) {
			$this->password = '';
			$this->isInitialized = false;
		}
	}

	/**
	 * Add information about the mount point in the ownCloud's FS where this storage
	 * will be used. This is expected to be the same as what is configured in the
	 * mount point configuration (it should be "WindowsNetworkDrive" by default).
	 * Note that the same storage might be accesible from different mount points:
	 * mounts "WND1" and "WND2" might use the same storage if the storage configuration
	 * and / or the storage id is the same for both mounts.
	 * In addition, associated the user with that particular mount point. This means that
	 * if the user access to that mount point, this storage object will be used.
	 *
	 * This is intended to be called only by the storage factory, not in any other place.
	 * @param string $mountPoint the mount point configured.
	 * @param IUser $user the user associated with that mount point
	 */
	public function addMountWithUser(string $mountPoint, IUser $user) {
		if (!isset($this->mountsWithUsers[$mountPoint])) {
			$this->mountsWithUsers[$mountPoint] = [];
		}
		$this->mountsWithUsers[$mountPoint][] = $user;
	}

	/**
	 * Get a map whose keys are the mount point associated to this storages and the values
	 * are a list of users who can access to this storage via the mount point.
	 *
	 * It's common that a mount point has multiple users (the mount point name is the same
	 * for all the users), but it might be possible that some users have a different mount
	 * point
	 *
	 * @return array<string, IUser[]> a mountPoint => userList map
	 */
	public function getMountsWithUsers() {
		return $this->mountsWithUsers;
	}

	/**
	 *  Validate the configuration params, which has been provided
	 *  @throws StorageNotAvailableException if the configuration is invalid
	 *  @return true if configuration is valid
	 */
	public function validateConfiguration() {
		if (str_contains($this->getRoot(), '\\') === true) {
			throw new StorageNotAvailableException('"\" Backslash characters not allowed in root');
		}

		if (str_contains($this->getShareName(), '\\') === true) {
			throw new StorageNotAvailableException('"\" Backslash characters not allowed in share name');
		}

		if ($this->getPassword() === '' && $this->getUser() !== '') {
			throw new StorageNotAvailableException('Password required when username given');
		}

		return true;
	}
}
