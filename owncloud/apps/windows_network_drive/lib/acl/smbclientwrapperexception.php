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

class SmbclientWrapperException extends \Exception {
	public static $errorMap = [
		1 => "Operation not permitted",  // EPERM
		2 => "No such file or directory",  // ENOENT
		12 => "Out of memory",  // ENOMEM
		13 => "Permission denied",  // EACCESS
		20 => "Not a directory",  // ENOTDIR
		22 => "Invalid argument",  // EINVAL
		110 => "Connection timed out",  // ETIMEDOUT
		111 => "Connection refused",  // ECONNREFUSED
		113 => "No route to host",  // EHOSTUNREACH
	];

	/** @var string */
	private $path;

	public function __construct($path, $errorCode) {
		if (isset(self::$errorMap[$errorCode])) {
			$message = self::$errorMap[$errorCode];
		} else {
			$message = "Unknown error";
		}
		$message .= " on $path";
		parent::__construct($message, $errorCode);
		$this->path = $path;
	}

	/**
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}
}
