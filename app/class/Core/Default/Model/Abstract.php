<?php
/**
 *....................................................................................
 *                                 Abstract.php                                      *
 * ..................................................................................*
 *
 * This is a model file. A model file is responsible defining entities in the
 * application. Models will define the characteristics of an entity and define useful
 * methods that are used by the application for managing those properties.
 *
 * File     : Abstract.php
 * contains : class
 * Location : app/class/Core/Default/Model/Abstract.php
 */

 /**
  * Core_Default_Model_Abstract Class
  *
  * This is the parent class of all models. So this class will hold all common
  * utilities which are used by every other models in the application.
  */
 class Core_Default_Model_Abstract extends BasicObject
 {

 	/**
 	 * Constructor
 	 *
 	 * @return   Core_Default_Model_Abstract
 	 */
 	public function __construct()
 	{
 		return $this;
 	}

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
	 * Model initialization.
	 *
	 * A model should be initialized with a valid resource. Without having a valid
	 * resource, a model can't make a collection or retrieve an item from database.
	 * 
	 * @param  string                      $resourceRef
	 * @return Core_Default_Model_Abstract
	 */
	protected function _init($resourceRef)
	{
		$this->_resource = App::getResource($resourceRef);
		return $this;
	}
 }
