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
 * Query Type Abstract Class
 *
 * This class is used to process any type of query.
 *
 * @category Core
 * @package  Core_Db
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Core_Db_Mysql_Query_Type_Abstract
{

	/**
	 * Use to store the query array.
	 *
	 * @var array
	 */
	protected $_query;

	/**
	 * Use to store table name.
	 *
	 * @var string
	 */
	protected $_table = '';

	/**
	 * Use to store db name.
	 *
	 * @var string
	 */
	protected $_db = '';

	/**
	 * Constructor
	 *
	 * @param string $query
	 * @param string $table
	 * @param string $db
	 */
	protected function __construct($query, $table, $db)
	{
		$this->_query = $query;
		$this->_table = $table;
		$this->_db = $db;
		return $this;
	}
}