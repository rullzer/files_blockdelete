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

namespace OCA\BlockDelete\Wrapper;

use OC\Files\Storage\Wrapper\Wrapper;

class Block extends Wrapper {
	/**
	 * @var string[] Directories to block being deleted
	 */
	private $block;

	/**
	 * @param array $parameters
	 */
	public function __construct($parameters) {
		parent::__construct($parameters);
		$this->block = $parameters['block'];
	}

	public function isDeletable($path) {
		$parts = explode('/', $path);

		if (count($parts) === 2 && $parts[0] === 'files' && in_array($parts[1], $this->block)) {
			return false;
		}

		return parent::isDeletable($path);
	}
}
