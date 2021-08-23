<?php
/**
 * @author Juan Pablo Villafañez Ramos <jvillafanez@owncloud.com>
 *
 * @copyright Copyright (c) 2019, ownCloud GmbH
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

namespace OCA\windows_network_drive\lib\acl\groupmembership;

use OCA\windows_network_drive\lib\acl\IGroupMembership;
use OCP\IGroupManager;
use OCP\IUserManager;

/**
 * Assume that the group membership can be retrieved via ownCloud's group manager
 * This requires that ownCloud has LDAP connection to the same AD / LDAP that the
 * windows / samba server is using.
 * Note that the domain can't be retrieved from ownCloud's side, so it will remain unknown
 *
 * It might be possible to create local groups and copy the same membership information
 * but this isn't intended and it's also error-prone. It will cause problems on the long run.
 */
class OCLDAPMembership implements IGroupMembership {
	/** @var IGroupManager */
	private $groupManager;
	/** @var IUserManager */
	private $userManager;

	/**
	 * @param IGroupManager $groupManager
	 */
	public function __construct(IUserManager $userManager, IGroupManager $groupManager) {
		$this->userManager = $userManager;
		$this->groupManager = $groupManager;
	}

	/**
	 * @inheritdoc
	 */
	public function getGroupMembers($group) {
		//strip the domain from the group if any
		$group = $this->stripDomain($group);
		$groupObj = $this->groupManager->get($group);

		if ($groupObj) {
			$userList = [];
			$users = $groupObj->getUsers();
			foreach ($users as $user) {
				$userList[] = $user->getUID();
			}
			return $userList;
		} else {
			throw new MissingGroupException();
		}
	}

	/**
	 * @inheritdoc
	 */
	public function isInGroup($user, $group) {
		$user = $this->stripDomain($user);
		$group = $this->stripDomain($group);

		$groupObj = $this->groupManager->get($group);
		if ($groupObj) {
			$userObj = $this->userManager->get($user);
			if ($userObj) {
				return $groupObj->inGroup($userObj);
			} else {
				throw new MissingUserException();
			}
		} else {
			throw new MissingGroupException();
		}
	}

	/**
	 * @inheritDoc
	 */
	public function fixUser($user) {
		return $this->stripDomain($user);
	}

	private function stripDomain($item) {
		if (\strpos($item, '\\') !== false) {
			$parts = \explode('\\', $item, 2);
			$item = $parts[1];
		}
		return $item;
	}
}
