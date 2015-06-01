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
 * SELECT Query Class
 *
 * This class is used to process a select query.
 *
 * @category Core
 * @package  Core_Db
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Core_Db_Mysql_Query_Type_Select extends Core_Db_Mysql_Query_Type_Abstract
{

	/**
	 * Indicator for select fields.
	 *
	 * @var boolean
	 */
	protected $noField = false;

	/**
	 * Indicator for where clause
	 *
	 * @var boolean
	 */
	protected $noWhere = false;

	/**
	 * Constructor
	 *
	 * @param string $query
	 * @param string $table
	 * @param string $db
	 */
	public function __construct($query, $table, $db)
	{
		if (!isset($query['select_fields'])
			|| (isset($query['select_fields']['all'] ))
		) {
			$this->noField = true;
		}

		if (!isset($query['where'])
			|| (isset($query['where']['all']))
		) {
			$this->noWhere = true;
		}

		parent::__construct($query, $table, $db);
		return $this;
	}

	/**
	 * Use to prepare a select query.
	 *
	 * @return string
	 */
	public function prepare()
	{

		$selectQuery = 'SELECT ';

		if ($this->noField) {
			$selectQuery .= Core_Db_Query::EVERY_FIELD;
		} else{
			$selectQuery .= $this->addFields($this->_query['select_fields']);
		}

		$selectQuery .= ' FROM ' . $this->_table;

		if ($this->noWhere) {
			$selectQuery .= ' WHERE ' . Core_Db_Query::WHERE_ALL;
		} else{
			$selectQuery .= $this->where($this->_query['where']);
		}

		return  $selectQuery;
	}

	/**
	 * Use to prepare fields section
	 *
	 * @param string $fields
	 */
	protected function addFields($fields)
	{
		return implode(',', $fields);
	}

	/**
	 * Use to prepare where clause.
	 *
	 * @param  array $where
	 * @return string
	 */
	protected function where($where)
	{
		$q = ' WHERE ';
		$count = count($where);
		foreach ($where as $key => $condition) {
			if (($count - 1) == $key) {
				$condition['relation'] = '';
			} else {
				$condition['relation'] = $condition['relation'] . ' ';
			}
			$q .= $condition['field']
				. ' '
				. $condition['operator']
				. ' '
				. $condition['value']
				. ' '
				. $condition['relation'];
		}

		return $q;
	}
}