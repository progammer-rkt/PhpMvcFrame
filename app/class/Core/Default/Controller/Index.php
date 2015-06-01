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
 * Core_Default_Controller_Index Class
 *
 * This controller is the default controller class. If no controller action is
 * specified in the appliction, then this is the class that is going to handle the
 * request.
 *
 * This is a perfect place for placing default actions that are essential in the
 * framework.
 *
 * @category Core
 * @package  Core_Default
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Core_Default_Controller_Index extends Core_Default_Controller_Abstract
{

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Index Action
	 *
	 * This is the default action of the application. Means no controller action is
	 * specified, then this method is going to trigger by the application.
	 *
	 * @return void
	 */
	public function Index()
	{
		$content = 'test_content';
		$this->addBlock('core_default/index_index', 'index_block');
		$this->getBlock('index_block')->setContent($content);

		$this->render();
	}

	/**
	 * NotFound Action
	 *
	 * This function is used to handle the 404 error in the application.
	 *
	 * @return void
	 */
	public function NotFound()
	{

	}
}