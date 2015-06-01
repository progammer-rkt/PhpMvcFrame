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
 * Query Constant class
 *
 * This class is dedicated to hold some useful constant which can be referred in
 * datbase query operations.
 *
 * @category Core
 * @package  Core_Db
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Core_Db_Query
{
	const EQUALS           = '=';
	const NOT_EQUAL        = '!=';
	const GREATER          = '>';
	const LESSER           = '<';
	const GREATER_OR_EQUAL = '>=';
	const LESSER_OR_EQUAL  = '<=';

	const SELECT = 'SELECT';
	const DROP   = 'DROP';
	const INSERT = 'INSERT';
	const UPDATE = 'UPDATE';
	const DELETE = 'DELETE';

	const EVERY_FIELD = '*';
	const WHERE_ALL   = 1;
}