<?php
/**
 * @author Sujith Haridasan <sharidasan@owncloud.com>
 * @copyright (C) 2019 ownCloud GmbH
 * @license ownCloud Commercial License
 *
 * This code is covered by the ownCloud Commercial License.
 *
 * You should have received a copy of the ownCloud Commercial License
 * along with this program. If not, see <https://owncloud.com/licenses/owncloud-commercial/>.
 *
 */

use OCA\Metrics\Application;

$app = new Application();
$app->registerRoutes(
	$this, // @phan-suppress-current-line PhanUndeclaredThis @phpstan-ignore-line
	[
		// user metrics end point
		'ocs' => [
			['name' => 'UserMetrics#getMetrics', 'url' => '/api/v1/metrics'],
		],
		'routes' => [
			['name' => 'Download#downloadAsAdmin', 'url' => '/download-web'],
			['name' => 'Download#downloadAsGuest', 'url' => '/download-api'],
			['name' => 'Page#get', 'url' => '/metrics'],
			['name' => 'Page#token', 'url' => '/token']
		]
	]
);
