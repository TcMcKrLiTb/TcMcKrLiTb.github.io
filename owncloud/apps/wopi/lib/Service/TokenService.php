<?php /** @noinspection HtmlUnknownTag */

/**
 * ownCloud Wopi
 *
 * @author Thomas Müller <thomas.mueller@tmit.eu>
 * @copyright 2018 ownCloud GmbH.
 *
 * This code is covered by the ownCloud Commercial License.
 *
 * You should have received a copy of the ownCloud Commercial License
 * along with this program. If not, see <https://owncloud.com/licenses/owncloud-commercial/>.
 *
 */

namespace OCA\WOPI\Service;

use Firebase\JWT\JWT;
use OC\AppFramework\Middleware\Security\Exceptions\SecurityException;
use OCP\AppFramework\Utility\ITimeFactory;
use OCP\IConfig;
use OCP\IUser;

require_once __DIR__ . '/../../vendor/autoload.php';

class TokenService {

	/** @var IConfig */
	private $config;
	/** @var ITimeFactory */
	private $timeFactory;

	/**
	 * @param IConfig $config
	 * @param ITimeFactory $timeFactory
	 */
	public function __construct(IConfig $config,
								ITimeFactory $timeFactory) {
		$this->config = $config;
		$this->timeFactory = $timeFactory;
	}

	/**
	 * @param string $fileId
	 * @param string $folderUrl
	 * @param IUser $user
	 * @return array
	 * @throws \Exception
	 */
	public function GenerateNewAuthUserAccessToken(string $fileId, string $folderUrl, IUser $user): array {
		if ($fileId === '' || $folderUrl === '') {
			throw new \InvalidArgumentException();
		}
		$key = $this->getTokenKey();

		$expiry = $this->timeFactory->getTime() + (int)$this->config->getAppValue('wopi', 'access-token.validity', (string)(4 * 60 * 60));
		$token = JWT::encode([
			'uid' => $user->getUID(),
			'fid' => $fileId,
			'furl' => $folderUrl,
			'exp' => $expiry
		], $key);

		return [
			'token' => $token,
			'expires' => $expiry * 1000
		];
	}

	/**
	 * @param string $fileId
	 * @param string $folderUrl
	 * @param string $shareToken
	 * @return array
	 * @throws \Exception
	 */
	public function GenerateNewPublicLinkAccessToken(string $fileId, string $folderUrl, $shareToken): array {
		if ($fileId === '' || $folderUrl === '') {
			throw new \InvalidArgumentException();
		}
		$key = $this->getTokenKey();

		$expiry = $this->timeFactory->getTime() + (int)$this->config->getAppValue('wopi', 'access-token.validity', (string)(4 * 60 * 60));
		$token = JWT::encode([
			'uid' => '',
			'st' => $shareToken,
			'fid' => $fileId,
			'furl' => $folderUrl,
			'exp' => $expiry
		], $key);

		return [
			'token' => $token,
			'expires' => $expiry * 1000
		];
	}

	/**
	 * @param string $access_token
	 * @param string $fileId
	 * @return array
	 * @throws SecurityException
	 */
	public function verifyToken(string $access_token, string $fileId): array {
		try {
			$token = JWT::decode($access_token, $this->getTokenKey(), ['HS256']);
			if ($token->fid !== $fileId) {
				throw new SecurityException('Token not for the given fileId', 401);
			}

			if ($token->uid !== '') {
				return [
					'UserId' => $token->uid,
					'FolderUrl' => $token->furl
				];
			} else {
				return [
					'ShareToken' => $token->st,
					'FolderUrl' => $token->furl
				];
			}
		} catch (\UnexpectedValueException $ex) {
			throw new SecurityException($ex->getMessage(), 401);
		}
	}

	/**
	 * Reads the jwt secret key which is used for jwt computation
	 * @return string
	 * @throws \Exception
	 */
	private function getTokenKey() : string {
		$key = $this->config->getSystemValue('wopi.token.key', null);
		if ($key === null) {
			throw new \Exception('System configuration <wopi.token.key> is missing');
		}
		return $key;
	}
}
