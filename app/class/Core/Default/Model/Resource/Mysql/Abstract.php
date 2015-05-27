<?php
/**
 *....................................................................................
 *                                 Abstract.php                                       *
 * ...................................................................................*
 *
 * This is a resource file. Resource files are used to communicate with database. you
 * can include databse quries here. A resource file should manage both collection and
 * an entity simultaneously.
 *
 * File     : Abstract.php
 * contains : class
 * Location : app/class/Core/Default/Model/Resource/Mysql/Abstract.php
 */

/**
 * Core_Default_Model_Resource_Mysql_Abstract Class
 *
 * This class is the ultimate resource class. Every resources will extend this class
 * and thus the utilities provided by this abstract class.
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
	 * Use to store a single entity.
	 *
	 */
	protected $entity = '';

	/**
	 * Use to store a collection
	 *
	 */
	protected $collection = '';

	/**
	 * constructor
	 *
	 * @return Core_Default_Model_Resource_Mysql_Abstract
	 */
	public function __construct()
	{
		$this->$connection = $this->makeConnection();
		return $this;
	}

	/**
	 * Use to load an entity
	 *
	 * @param  int $id
	 * @return Core_Default_Model_Resource_Abstract
	 */
	public function load($id)
	{

	}

	/**
	 * Use to get full collection of the entity
	 *
	 */
	public function getCollection()
	{

	}

	/**
	 * Use to filter out collection
	 *
	 */
	public function addFilter()
	{

	}

	/**
	 * Use to connect with active database.
	 *
	 * @return Core_Default_Model_Resource_Mysql_Abstract
	 */
	protected function makeConnection()
	{
		//retrieve server, username and password from active database
		$dbConfigFile = self::_getConfigJsonFile('database_config');
		$activeDBRef = $this->getParser()->input($dbConfigFile)
			->getConfigNode('active_database');
		$activeDb = $this->_getActiveDatabase($activeDBRef); //stdClass
		$servername = $activeDb->server;
		$username = $activeDb->username;
		$password = $activeDb->password;

		// Create connection
		$conn = mysqli_connect($servername, $username, $password);

		// Check connection
		if (!$conn) {
		    throw new Exception("Connection failed: " . mysqli_connect_error());
		}

		$this->connection = $conn;
		$this->$dbName = $activeDb->name;
		return $this;
	}

	/**
	 * Use to get the json parser object.
	 *
	 * @return Core_Json_Parser
	 */
	protected function getParser()
	{
		return App::getClass('core_json/parser')
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
		$dbConfigFile = self::_getConfigJsonFile('database_config');
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
}
