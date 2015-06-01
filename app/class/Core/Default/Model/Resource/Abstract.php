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
 * Core_Default_Model_Resource_Abstract Class
 *
 * This class is the ultimate resource class. Every resources will extend this class
 * and thus the utilities provided by this abstract class.
 *
 * @category Core
 * @package  Core_Default
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
Final class Core_Default_Model_Resource_Abstract extends BasicObject
{
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
}
