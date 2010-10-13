<?php
declare(ENCODING = 'utf-8');
namespace F3\Importer\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "Importer".                   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Standard controller for the Importer package
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class DemoController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * @var \F3\Importer\Domain\Repository\DemoRepository
	 * @inject
	 */
	protected $demoRepository;


	/**
	 * Index action
	 * Shows a welcome screen with some instr
	 *
	 * @return void
	 */
	public function indexAction() {
		$demos = $this->demoRepository->findAll();
		$this->view->assign('demos', $demos);
	}
}
?>