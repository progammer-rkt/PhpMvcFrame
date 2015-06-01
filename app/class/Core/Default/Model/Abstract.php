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
  * Core_Default_Model_Abstract Class
  *
  * This is the parent class of all models. So this class will hold all common
  * utilities which are used by every other models in the application.
  *
  * @category Core
  * @package  Core_Default
  * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
  */
class Core_Default_Model_Abstract extends BasicObject
{

	/**
	 * Use to set collection.
	 *
	 * @var array
	 */
	protected $_collection;

	/**
	 * Use to set data.
	 *
	 * @var Core_Object_Entity
	 */
	protected $_data;

	/**
	 * hold to store the resource
	 *
	 * @var BasicObject
	 */
	protected $_resource = '';

 	/**
	 * Use to get the resource
	 *
	 * @return BasicObject
	 */
	public function getResource()
	{
		return $this->_resource;
	}

	/**
	 * Use to get full collection.
	 *
	 * @return array
	 */
	public function getAll()
	{
		$all = $this->getResource()->getCollection()->load();
		return $this->setCollection($all)->getCollection();

	}

	/**
	 * Use to load an entity item.
	 *
	 * @param  int                          $id
	 * @return Core_Default_Model_Abstract
	 */
	public function load($id)
	{
		$all = $this->getResource()->load($id);
		$this->setData($all)->getData();
		return $this;
	}

	/**
	 * Use to set a collection on model.
	 *
	 * @param array                         $collection
	 * @return Core_Default_Model_Abstract
	 */
	public function setCollection($collection)
	{
		$this->_collection = $collection;
		return $this;
	}

	/**
	 * Use to get collection of a model.
	 *
	 * @return array
	 */
	public function getCollection()
	{
		return $this->_collection;
	}

	/**
	 * Use to set an entity on a model.
	 *
	 * @param  Core_Object_Entity           $data
	 * @return Core_Default_Model_Abstract
	 */
	public function setData($data)
	{
		if ($data instanceof Core_Object_Entity) {
			$this->_data = $data;
		}
		if (is_array($data)) {
			if (!$this->_data instanceof Core_Object_Entity) {
				$this->_data = App::getClass('core_object/entity');
			}
			foreach ($data as $property => $value) {
				$this->_data->$property = $value;
			}
		}
		return $this;
	}

	/**
	 * Use to get an entity from a model.
	 *
	 * @param  string $data
	 * @return mixed
	 */
	public function getData($data = null)
	{
		if (is_null($data)) {
			return $this->_data;
		} else {
			return $this->_data->$data;
		}
	}

	/**
	 * Model initialization.
	 *
	 * A model should be initialized with a valid resource. Without having a valid
	 * resource, a model can't make a collection or retrieve an item from database.
	 *
	 * @param  string                       $resourceRef
	 * @return Core_Default_Model_Abstract
	 */
	protected function _init($resourceRef)
	{
		$this->_resource = App::getResource($resourceRef);
		return $this;
	}
}
