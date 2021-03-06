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
 * Core_Default_Model_Index Class
 *
 * This is just an example of default entity model. Please how we are initializing
 * resources via model.
 *
 * @category Core
 * @package  Core_Default
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Core_Default_Model_Index extends Core_Default_Model_Abstract
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
