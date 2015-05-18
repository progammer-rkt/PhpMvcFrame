<?php
/**
 * ...................................................................................
 *                                   Index.php                                        *
 * ...................................................................................*
 * 
 * This is a model file. A model file is used to define an entity in the application.
 * An application holds several indivudual entities that together acts and constitutes
 * application. Each entity has it's own characteristics. A model file will hence
 * hold such properties and provide us methods that will use to manage those propeties.
 * 
 * File     : Fundraiser.php
 * contains : class
 * Location : app/class/Core/Default/Model/Index.php
 */

/**
 * Core_Default_Model_Index Class
 *
 * This is just an example of default entity model. Please how we are initializing
 * resources via model.
 */
class Core_Default_Model_Index extends Demo_Fundraiser_Model_Virtual_Abstract
{

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->_init('core_default/default');
		parent::__construct();
	}

} 
