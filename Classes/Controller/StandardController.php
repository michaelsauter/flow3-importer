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
class StandardController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * Value for mapping
	 */
	const MAPPING_NONE = '-none-';

	/**
	 * @var \F3\Importer\Domain\Model\Mapping
	 * @inject
	 */
	protected $mapping;


	/**
	 * Index action
	 * Shows a welcome screen with some instructions
	 *
	 * @return void
	 */
	public function indexAction() {	}

	/**
	 * Step 1
	 * Let's you enter DB details and select a package
	 */
	public function stepOneAction() {
		// get all packages
		$packageManager = $this->objectManager->get('F3\FLOW3\Package\PackageManager');
		$packageManager->initialize();
		$packages = $packageManager->getAvailablePackages();
		$packagesList = array();
		foreach ($packages as $key => $value) {
			$packagesList[$key] = $key;
		}
		$this->view->assign('packages', $packagesList);
	}

	/**
	 * Step 2
	 * Let's you select a table and a model
	 *
	 * @param string $dbname
	 * @param string $host
	 * @param string $username
	 * @param string $password
	 * @param string $packageKey
	 */
	public function stepTwoAction($databaseName, $host, $username, $password, $packageKey) {
		// update mapping model
		$this->mapping->setHost($host);
		$this->mapping->setUsername($username);
		$this->mapping->setPassword($password);
		$this->mapping->setDatabaseName($databaseName);
		$this->mapping->setPackageKey($packageKey);

		// get tables
		$tables = array();
		$db = new \PDO('mysql:dbname=' . $databaseName . ';host=' . $host, $username, $password);
		$result = $db->query("show tables");
		while ($row = $result->fetch(\PDO::FETCH_NUM)) {
				$tables[$row[0]] = $row[0];
		}
		$this->view->assign('tables', $tables);

		// models (getting only those with a repository)
		$models = array();
		$repositories = \F3\FLOW3\Utility\Files::readDirectoryRecursively(FLOW3_PATH_PACKAGES . 'Application/' . $packageKey . '/Classes/Domain/Repository');
		for ($i = 0; $i < count($repositories); $i++) {
			$modelNameStart = \strrpos($repositories[$i], '/') + 1;
			$modelNameEnd = \strrpos($repositories[$i], 'Repository.php');
			$modelName = \substr($repositories[$i], $modelNameStart, $modelNameEnd - $modelNameStart);
			$models[$modelName] = $modelName;
		}
		$this->view->assign('models', $models);
	}
	
	/**
	 * Step 3
	 * Let's you map attributes to properties
	 *
	 * @param string $tableName
	 * @param string $modelName
	 */
	public function stepThreeAction($tableName, $modelName) {
		// update mapping model
		$this->mapping->setTableName($tableName);
		$this->mapping->setModelName($modelName);

		// get column names from table
		$attributes = array();
		$db = new \PDO('mysql:dbname=' . $this->mapping->getDatabaseName() . ';host=' . $this->mapping->getHost(), $this->mapping->getUsername(), $this->mapping->getPassword());
		$result = $db->query('SHOW COLUMNS FROM ' . $this->mapping->getTableName());
		while ($row = $result->fetch(\PDO::FETCH_NUM)) {
				$attributes[] = $row[0];
		}
		$this->view->assign('attributes', $attributes);
		
		// reflect over model (get properties that can be set)
		$model =  $this->objectManager->create($this->mapping->getModelClassName());
		$properties = \F3\FLOW3\Reflection\ObjectAccess::getSettablePropertyNames($model);
		$propertyList = array(self::MAPPING_NONE => self::MAPPING_NONE);
		for ($i = 0; $i < count($properties); $i++) {
			$propertyList[$properties[$i]] = $properties[$i];
		}
		$this->view->assign('properties', $propertyList);
		$this->view->assign('defaultProperty', self::MAPPING_NONE);
	}

	/**
	 * Step 4
	 * Imports the data
	 *
	 * @param array $mappings
	 */
	public function stepFourAction(array $mappings) {
		// update mapping model
		$this->mapping->setMappings($mappings);

		// create repository
		$repository = $this->objectManager->get($this->mapping->getRepositoryClassName());

		// connect to DB and retrieve all records
		$db = new \PDO('mysql:dbname=' . $this->mapping->getDatabaseName() . ';host=' . $this->mapping->getHost(), $this->mapping->getUsername(), $this->mapping->getPassword());
		$result = $db->query('SELECT * FROM ' . $this->mapping->getTableName());
		$i = 0;

		// for each row, create a new instance of model and add it to repository
		while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
			$i++;
			$model = $this->objectManager->create($this->mapping->getModelClassName());
		  foreach ($row as $key => $value) {
				$attributeToPropertyMapping = $this->mapping->getMappings();
				$propertyName = $attributeToPropertyMapping[$key];
				if ($propertyName != self::MAPPING_NONE) {
					\F3\FLOW3\Reflection\ObjectAccess::setProperty($model, $propertyName, $value);
				}
			}
			$repository->add($model);
		}

		// display how many records where imported
		$this->view->assign('recordsImported', $i);
	}
}
?>