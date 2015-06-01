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
 * @package    Core_Db
 * @copyright  Copyright (c) 2015
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Mysql Query class
 *
 * This class is used to make mysql database related operations.
 *
 * @category Core
 * @package  Core_Db
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Core_Db_Mysql_Query extends BasicObject
{

	/**
	 * Use to hold a valid server connection instance.
	 *
	 * @var mixed
	 */
	protected $connection;

    /**
	 * Use to store db name.
	 *
	 * @var string
	 */
	protected $dbName;

	/**
	 * Use to hold table name.
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * Use to store the count of result of a query.
	 *
	 * @var integer
	 */
	protected $count = 0;

	/**
	 * Use to hold query array.
	 *
	 * array (
	 *     'type',
	 *     'select_fields' => array(
	 *         [['all' => 1,]]
	 *         'field-1', 'field-2', 'field-3', 'so-on'
	 *     )
	 *
	 * )
	 * @var array
	 */
	protected $query = array();


	/**
	 * Use to set current table name.
	 *
	 * @param  string               $table
	 * @return Core_Db_Mysql_Query
	 */
	public function setTableName($table)
	{
		$this->table = $table;
		return $this;
	}

	/**
	 * Use to set current database name.
	 *
	 * @param  string               $db
	 * @return Core_Db_Mysql_Query
	 */
	public function setDbName($db)
	{
		$this->dbName = $db;
		return $this;
	}

	/**
	 * Use to set query type.
	 *
	 * @param  string               $type
	 * @throws Exception
	 * @return Core_Db_Mysql_Query
	 */
	public function addQueryType($type)
	{
		$availableQueryTypes = array(
			Core_Db_Query::SELECT,
			Core_Db_Query::DROP,
			Core_Db_Query::INSERT,
			Core_Db_Query::UPDATE,
			Core_Db_Query::DELETE,

		);
		if (in_array($type, $availableQueryTypes)) {
			$this->query['type'] = $type;
		} else {
			throw new Exception("Query Type `" . $type . "Does not Exist..");
		}

		return $this;
	}

	/**
	 * Use to add select fields.
	 *
	 * @param  mixed               $fields
	 * @throws Exception
	 * @return Core_Db_Mysql_Query
	 */
	public function addSelectFields($fields)
	{
		if ($fields == Core_Db_Query::EVERY_FIELD) {
			$fields = array('all' => '*');
		}

		if (is_string($fields)) {
			$fields = explode(',', $fields);
		}

		if (is_array($fields)) {
			if (count($fields) > 1
				&& isset($this->query['select_fields']['all'])
			) {
				unset($this->query['select_fields']['all']);
			}
			$this->query['select_fields'] = $fields;
		} else {
			throw new Exception(
				"Select-fields must be provided as an array or it should be `*` (string)"
			);

		}
		return $this;
	}

	/**
	 * Use to add a WHERE Clause.
	 *
	 * @param  string               $field
	 * @param  string               $value
	 * @param  string               $operator
	 * @param  mixed                $whereRelation
	 * @throws Exception
	 * @return Core_Db_Mysql_Query
	 */
	public function addWHERE(
		$field = '',
		$value = '',
		$operator = Core_Db_Query::EQUALS,
		$whereRelation = false
	) {

		//determine the right relation
		$relation = 'AND';
		$OR = array(true, 'or', 'OR', 'Or', 'oR');
		if (in_array($whereRelation, $OR)) {
			$relation = 'OR';
		}

		//WHERE 1 is requested. So set `all` attribute as 1;
		if ($operator == Core_Db_Query::WHERE_ALL) {
			$this->query['where']['all'] = 1;
			return $this;
		}

		//preparing a normal where condition
		// eg: WHERE $field = $value AND
		$availableOperators = array(
			Core_Db_Query::EQUALS,
			Core_Db_Query::NOT_EQUAL,
			Core_Db_Query::GREATER,
			Core_Db_Query::LESSER,
			Core_Db_Query::GREATER_OR_EQUAL,
			Core_Db_Query::LESSER_OR_EQUAL,
		);
		if (!in_array($operator, $availableOperators)) {
			throw new Exception('`' . $operator . '` is not a valid WHERE condition');
		}
		if (isset($this->query['where']['all'])) {
			unset($this->query['where']['all']);
		}
		$this->query['where'][] = array(
			'field'    => $field,
			'value'    => $value,
			'operator' => $operator,
			'relation' => $relation
		);

		return $this;
	}

	/**
	 * Use to make a connection to the server.
	 *
	 * @param  string               $server
	 * @param  string               $username
	 * @param  string               $password
	 * @return Core_Db_Mysql_Query
	 */
	public function trigger($server, $username = 'root', $password = '')
	{
		// Create connection
		$conn = mysqli_connect($server, $username, $password);

		// Check connection
		if (!$conn) {
		    throw new Exception("Connection failed: " . mysqli_connect_error());
		}

		$this->connection = $conn;
		return $this;
	}

	/**
	 * Use to prepare the mysql query.
	 *
	 * @throws Exception
	 * @return string
	 */
	public function prepareQuery()
	{
		//so a valid query type exist.
		if (isset($this->query['type'])) {
			$type = $this->query['type'];
		} else {
			//no valid query type exist. error
			throw new Exception("No Query Exists.");
		}

		$query = $this->_prepareQueryByType($type);
		return $query;
	}

	/**
	 * Use to get query output.
	 *
	 * @param  string      $query
	 * @throws Exception
	 * @return array       $rows
	 */
	public function getOutput($query)
	{
		if ($this->connection->select_db($this->dbName)) {
			/**
			 * Returns FALSE on failure.
			 *
			 * For successful SELECT, SHOW, DESCRIBE or EXPLAIN queries
			 * mysqli_query() will return a mysqli_result object.
			 *
			 * For other successful queries mysqli_query() will return TRUE.
			 */
			$result = $this->connection->query($query);
			if ($result ===  false) {
				throw new Exception('Query Failed : [QUERY :'
					. $query . '][ERROR:' . $this->connection->error . ']'
				);
			}
			$this->count = $result->num_rows;
			if ($this->count > 0) {
				$rows = array();
				while ($rw = $result->fetch_assoc()) {
					$rows[] = $rw;
				}
			} else {
				$rows = false;
			}

			/* free result set */
    		$result->free();
			$this->connection->close();

			return $rows;
		} else {
			throw new Exception('Database `' . $this->dbName. '` Does not exist.');

		}
	}

	/**
	 * Use to get the result count.
	 *
	 * This will return the count of rows which produced by last query.
	 *
	 * @return int
	 */
	public function getResultCount()
	{
		return $this->count;
	}

	/**
	 * Use to prepare based on query type.
	 *
	 * There will be a special class for each query type and that
	 * specific class is responsible for preparing the whole query.
	 * This is because, select, insert, create quries are working
	 * differently and hence they need different processes.
	 *
	 * @param  string $type
	 * @return stirng $query
	 */
	protected function _prepareQueryByType($type)
	{
		$queryType = ucfirst(strtolower($type));
		$className = 'Core_Db_Mysql_Query_Type_' . $queryType;
		$typeInstance = new $className($this->query, $this->table, $this->dbName);
		$query = $typeInstance->prepare();
		return $query;
	}
}