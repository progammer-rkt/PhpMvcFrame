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
 * Location : app/class/Core/Default/Model/Resource/Abstract.php
 */

/**
 * Core_Default_Model_Resource_Abstract Class
 *
 * This class is the ultimate resource class. Every resources will extend this class
 * and thus the utilities provided by this abstract class.
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
