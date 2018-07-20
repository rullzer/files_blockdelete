<?php
/**
 * @copyright 2018 Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @author Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\BlockDelete\AppInfo;

use OCA\BlockDelete\Wrapper\Manager;
use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;

class Application extends App {
	public function __construct(array $urlParams = []) {
		parent::__construct('files_excludedirs', $urlParams);

		$container = $this->getContainer();

		$container->registerService(Manager::class, function (IAppContainer $c) {
			$server = $c->getServer();
			return new Manager(
				$server->getConfig()
			);
		});
	}

	public function register() {
		$container = $this->getContainer();
		$manager = $container->query(Manager::class);

		\OCP\Util::connectHook('OC_Filesystem', 'preSetup', $manager, 'setupStorageWrapper');
	}
}
