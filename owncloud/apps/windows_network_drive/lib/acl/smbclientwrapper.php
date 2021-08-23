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

namespace OCA\windows_network_drive\lib\acl;

use OCA\windows_network_drive\lib\acl\models\SecurityDescriptor;

class SmbclientWrapper {
	/** @var resource */
	private $smbResource;
	/** @var string */
	private $host;
	/** @var string */
	private $share;

	public function __construct(
		string $host,
		string $share,
		string $workgroup,
		string $user,
		string $password
	) {
		$this->host = $host;
		$this->share = $share;
		$this->smbResource = \smbclient_state_new();
		\smbclient_state_init($this->smbResource, $workgroup, $user, $password);
	}

	/**
	 * @return string the host being accessed by this smbclient wrapper
	 */
	public function getHost() {
		return $this->host;
	}

	/**
	 * @return string the share being accessed by this smbclient wrapper
	 */
	public function getShare() {
		return $this->share;
	}

	/**
	 * @param string $path the paths within the share that will be changed
	 * @param SecurityDescriptor $descriptor the SecurityDescriptor that will be set in the path
	 * @throws SmbclientWrapperException if the SecurityDescriptor can't be set. The error code of the
	 * exception can be used to know the cause.
	 */
	public function setSecurityDescriptor($path, SecurityDescriptor $descriptor) {
		$path = \trim($path, '/');
		$smbPath = "smb://{$this->host}/{$this->share}/{$path}";
		$result = @\smbclient_setxattr($this->smbResource, $smbPath, 'system.nt_sec_desc.*+', $descriptor->toString());
		if ($result === false) {
			throw new SmbclientWrapperException($smbPath, \smbclient_state_errno($this->smbResource));
		}
	}

	/**
	 * @param string $path the path within the share to get the information from
	 * @return SecurityDescriptor|false the SecurityDescriptor for the path or false if
	 * there are error parsing the data
	 * @throws SmbclientWrapperException if we can't get the security descriptor from the server
	 * (probably connection or permission problems). The error code of the exception can be used
	 * to know the cause
	 */
	public function getSecurityDescriptor($path) {
		$path = \trim($path, '/');
		$smbPath = "smb://{$this->host}/{$this->share}/{$path}";
		$data = @\smbclient_getxattr($this->smbResource, $smbPath, 'system.nt_sec_desc.*+');
		if ($data === false) {
			throw new SmbclientWrapperException($smbPath, \smbclient_state_errno($this->smbResource));
		}
		return SecurityDescriptor::fromString($data);
	}

	public function __destruct() {
		if (\is_resource($this->smbResource)) {
			\smbclient_state_free($this->smbResource);
		}
	}
}
