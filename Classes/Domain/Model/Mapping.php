<?php
declare(ENCODING = 'utf-8');
namespace F3\Importer\Domain\Model;

/*                                                                        *
 * This script belongs to the FLOW3 package "Blog".                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License as published by the Free   *
 * Software Foundation, either version 3 of the License, or (at your      *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        *
 * You should have received a copy of the GNU General Public License      *
 * along with the script.                                                 *
 * If not, see http://www.gnu.org/licenses/gpl.html                       *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * A mapping
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @scope session
 */
class Mapping {

	/**
	 * @var string
	 */
	protected $host;

	/**
	 * @var string
	 */
	protected $username;

	/**
	 * @var string
	 */
	protected $password;

	/**
	 * @var string
	 */
	protected $databaseName;

	/**
	 * @var string
	 */
	protected $tableName;

	/**
	 * @var string
	 */
	protected $packageKey;

	/**
	 * @var string
	 */
	protected $modelName;

	/**
	 * @var array
	 */
	protected $mappings;

	/**
	 * Constructs this post
	 *
	 */
	public function __construct() {
		$this->mappings = array();
	}

	/* Sets the host
	 *
	 * @param string $host
	 * @return void
	 */
	public function setHost($host) {
		$this->host = $host;
	}

	/**
	 * Returns the host
	 *
	 * @return string
	 */
	public function getHost() {
		return $this->host;
	}

	/* Sets the username
	 *
	 * @param string $username
	 * @return void
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * Returns the username
	 *
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	/* Sets the password
	 *
	 * @param string $password
	 * @return void
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * Returns the password
	 *
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}

	/* Sets the databaseName
	 *
	 * @param string $databaseName
	 * @return void
	 */
	public function setDatabaseName($databaseName) {
		$this->databaseName = $databaseName;
	}

	/**
	 * Returns the databaseName
	 *
	 * @return string
	 */
	public function getDatabaseName() {
		return $this->databaseName;
	}

	/* Sets the tableName
	 *
	 * @param string $tableName
	 * @return void
	 */
	public function setTableName($tableName) {
		$this->tableName = $tableName;
	}

	/**
	 * Returns the tableName
	 *
	 * @return string
	 */
	public function getTableName() {
		return $this->tableName;
	}

	/* Sets the packageKey
	 *
	 * @param string $packageKey
	 * @return void
	 */
	public function setPackageKey($packageKey) {
		$this->packageKey = $packageKey;
	}

	/**
	 * Returns the packageKey
	 *
	 * @return string
	 */
	public function getPackageKey() {
		return $this->packageKey;
	}

	/* Sets the modelName
	 *
	 * @param string $modelName
	 * @return void
	 */
	public function setModelName($modelName) {
		$this->modelName = $modelName;
	}

	/**
	 * Returns the modelName
	 *
	 * @return string
	 */
	public function getModelName() {
		return $this->modelName;
	}

	/* Sets the mappings
	 *
	 * @param array $mappings
	 * @return void
	 */
	public function setMappings($mappings) {
		$this->mappings = $mappings;
	}

	/**
	 * Returns the mappings
	 *
	 * @return array
	 */
	public function getMappings() {
		return $this->mappings;
	}

	/**
	 * Returns the class name
	 *
	 * @return string
	 */
	public function getModelClassName() {
		return 'F3\\' . $this->getPackageKey() . '\Domain\Model\\' . $this->getModelName();
	}

	/**
	 * Returns the class name
	 *
	 * @return string
	 */
	public function getRepositoryClassName() {
		return 'F3\\' . $this->getPackageKey() . '\Domain\Repository\\' . $this->getModelName() . 'Repository';
	}
}
?>