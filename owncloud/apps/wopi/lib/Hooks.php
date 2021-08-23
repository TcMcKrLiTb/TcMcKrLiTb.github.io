<?php
/**
 * ownCloud Wopi
 *
 * @author Piotr Mrowczynski <piotr@owncloud.com>
 * @copyright 2021 ownCloud GmbH.
 *
 * This code is covered by the ownCloud Commercial License.
 *
 * You should have received a copy of the ownCloud Commercial License
 * along with this program. If not, see <https://owncloud.com/licenses/owncloud-commercial/>.
 *
 */

namespace OCA\WOPI;

use \OCP\Util;

class Hooks {
	public static function publicPage() {
		Util::addScript('wopi', 'script');
		Util::addStyle('wopi', 'style');

		if (!\interface_exists(\OCP\Files\Storage\IPersistentLockingStorage::class)) {
			throw new \OC\HintException('No locking in core - bye bye');
		}
	}
}
