<?php
/**
 * SimpleMage
 *...................................................................................
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License that is bundled with this package
 * in the file LICENSE_SM.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category   Core
 * @package    Core_Deafult
 * @copyright  Copyright (c) 2015
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Core_Default_Model_Resource_Mysql_Abstract Class
 *
 * This class is the ultimate resource class. Every resources will extend this class
 * and thus the utilities provided by this abstract class.
 *
 * @category Core
 * @package  Core_Default
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Core_Default_Model_Resource_Mysql_Abstract extends BasicObject
{

	/**
	 * use to store table name.
	 *
	 * @var string
	 */
	protected $_table;

	/**
	 * Use to store primary field name.
	 *
	 * @var string
	 */
	protected $_primaryField;

	/**
	 * Use to hold active database configuration.
	 *
	 * @var stdClass
	 */
	protected $db;

	/**
	 * constructor
	 *
	 * @return Core_Default_Model_Resource_Mysql_Abstract
	 */
	public function __construct()
	{
		$this->instance = App::getClass('core_db/mysql_query');
		$this->makeConnection();

		$this->instance->setTableName($this->_table);
		$this->instance->setDbName($this->db->name);

		return $this;
	}

	/**
	 * Use to load an entity
	 *
	 * @param  int $id
	 * @return Core_Default_Model_Resource_Abstract
	 */
	public function load($id = '')
	{
		$isEntity = false;
		//prepare query to load a single entity.
		if (is_numeric($id)) {
			$isEntity = true;
			$this->instance->addQueryType(Core_Db_Query::SELECT)
				->addSelectFields(Core_Db_Query::EVERY_FIELD)
				->addWHERE($this->_primaryField, $id, Core_Db_Query::EQUALS);
		}

		$query = $this->instance->prepareQuery();
		$result = $this->instance->getOutput($query);

		if($result === false) {
			return $this;
		}
		if ($this->instance->getResultCount() == 1) {
			$this->setData($result[0]);
		}
		if (!$isEntity) {
			$this->setBasicCollection($result);
		}

		if ($isEntity) {
			return $this->getData();
		} else{
			return $this->getBasicCollection();
		}
	}

	/**
	 * Use to get full collection of the entity
	 *
	 * @return Core_Default_Model_Resource_Mysql_Abstract
	 */
	public function getCollection()
	{
		$this->instance->addQueryType(Core_Db_Query::SELECT)
			->addSelectFields(Core_Db_Query::EVERY_FIELD)
			->addWHERE('', '', Core_Db_Query::WHERE_ALL);
		return $this;
	}

	/**
	 * Use to filter out collection
	 *
	 * @return Core_Default_Model_Resource_Mysql_Abstract
	 */
	public function addFieldToFilter(
		$field, $value, $operator = '==', $whereRelation = false
	) {
		$this->instance->addWHERE($field, $value, $operator, $whereRelation);
		return $this;
	}

	/**
	 * Use to add select fields.
	 *
	 * @param  mixed                                       $fields
	 * @return Core_Default_Model_Resource_Mysql_Abstract
	 */
	public function addFieldToSelect($fields)
	{
		$this->instance->addSelectFields($fields);
		return $this;
	}

	/**
	 * Use to connect with active database.
	 *
	 * @return Core_Default_Model_Resource_Mysql_Abstract
	 */
	protected function makeConnection()
	{
		//retrieve server, username and password from active database
		$dbConfigFile = App::_getConfigJsonFile('database_config');
		$activeDBRef = $this->getParser()->input($dbConfigFile)
			->getConfigNode('active_database');
		$activeDb = $this->_getActiveDatabase($activeDBRef); //stdClass
		$servername = $activeDb->server;
		$username = $activeDb->username;
		$password = $activeDb->password;

		$this->instance->trigger($servername, $username, $password);
		$this->db = $activeDb;
		return $this;
	}

	/**
	 * Use to get the json parser object.
	 *
	 * @return Core_Json_Parser
	 */
	protected function getParser()
	{
		return App::getClass('core_json/parser');
	}

	/**
	 * Use to find active database object from database configuration.
	 *
	 * @param  string   $dbId
	 * @return stdClass $database
	 */
	protected function _getActiveDatabase($dbId)
	{
		$database = false;
		$jsonParser = $this->getParser();
		$dbConfigFile = App::_getConfigJsonFile('database_config');
		$databases = $jsonParser->input($dbConfigFile)->getConfigNode('databases');
		foreach ($databases as $db) {
			if ($db->id == $dbId) {
				$database = $db;
			}
		}

		if ($database === false) {
			throw new Exception(
				"No active database exist. Please configure a valid Database first."
			);
		}

		return $database;
	}

	protected function _prepareFilterQueryArray(
		$field, $value, $operator, $whereRelation
	) {
		$query = array(
			'field' => trim($field),
			'value' => trim($value),
			'operator' => $operator,
			'related_by' => $whereRelation
		);
	}
}
