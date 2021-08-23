<?php
/**
 * ownCloud Wopi
 *
 * @author Semih Serhat Karakaya <karakayasemi@itu.edu.tr>
 * @copyright 2019 ownCloud GmbH.
 *
 * This code is covered by the ownCloud Commercial License.
 *
 * You should have received a copy of the ownCloud Commercial License
 * along with this program. If not, see <https://owncloud.com/licenses/owncloud-commercial/>.
 *
 */
namespace OCA\WOPI\AppInfo;
use \OCP\AppFramework\App;
use \OCA\WOPI\Hooks;
use \OCP\Util;

class Application extends App {
	/**
	 * Application constructor.
	 *
	 * @param array $urlParams
	 */
	public function __construct(array $urlParams=[]) {
		parent::__construct('wopi', $urlParams);
	}

	/**
	 * @throws \OC\HintException
	 */
	public function registerScripts() {
		if ($this->isUserAllowedToUseWOPI() || $this->publicLinksAllowedToUseWOPI()) {
			$eventDispatcher = \OC::$server->getEventDispatcher();
			$eventDispatcher->addListener(
				'OCA\Files::loadAdditionalScripts',
				function () {
					Util::addScript('wopi', 'script');
					Util::addStyle('wopi', 'style');
				});

			if (!\interface_exists(\OCP\Files\Storage\IPersistentLockingStorage::class)) {
				throw new \OC\HintException('No locking in core - bye bye');
			}
		}

		Util::connectHook("OCP\Share", "share_link_access", Hooks::class, "publicPage");
	}

	/**
	 * @return bool
	 */
	public function publicLinksAllowedToUseWOPI() {
		return ($this->getContainer()->getServer()->getConfig()->getAppValue('core', 'shareapi_allow_links', 'yes') == 'yes');
	}

	/**
	 * @return bool
	 */
	public function isUserAllowedToUseWOPI() {
		// no user -> no
		$userSession = $this->getContainer()->getServer()->getUserSession();
		if (empty($userSession) || !$userSession->isLoggedIn()) {
			return false;
		}
		// no group set -> all users are allowed
		$groupName = $this->getContainer()->getServer()->getConfig()->getSystemValue('wopi_group', null);
		if ($groupName === null) {
			return true;
		}
		// group unknown -> error and allow nobody
		$group = $this->getContainer()->getServer()->getGroupManager()->get($groupName);
		if (empty($group)) {
			$this->getContainer()->getServer()->getLogger()->error("Group is unknown $groupName", ['app' => 'wopi']);
			return false;
		}
		return $group->inGroup($userSession->getUser());
	}
}
