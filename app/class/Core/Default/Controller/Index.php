<?php
/**
 *...................................................................................
 *                                 Index.php                                         *
 *...................................................................................*
 *
 * This is a controller file. A controller is responsible for making a valid relation 
 * with model and view. This logic section combines model logic section with view 
 * logic section and thus the whole framework work together and forms the output.
 *
 * File     : Index.php
 * contains : class
 * Location : app/class/Core/Default/Controller/Index.php
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
 */
class Core_Default_Controller_Index
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
	 * @return  void
	 */
	public function Index()
	{
		$content = 'test_content';
		$this->addBlock('core_index/index_index', 'index_block');
		$this->getBlock('index_block')->setContent($content);

		$this->render();
	}

	/**
	 * 	NotFound Action
	 * 
	 * This function is used to handle the 404 error in the application.
	 * 
	 * @return void
	 */
	public function NotFound()
	{

	}
}