<?php
/**
 * ..................................................................................
 *                                 Abstract.php                                      *
 * ..................................................................................*
 *
 * This is a controller file. A controller is responsible for making a valid relation
 * with model and view. This logic section combines model logic section with view
 * logic section and thus the whole framework work together and forms the output.
 *
 * File     : Abstract.php
 * contains : class
 * Location : app/class/Core/Default/View/Abstract.php
 */

/**
 * Core_Default_Controller_Abstract Class
 *
 * This is the parent of all controller classes. So all common utilities of
 * controllers wil reside here.
 */
class Core_Default_Controller_Abstract extends BasicObject
{
	/**
	 * Constructor
	 *
	 * @return  void
	 */
	public function __construct()
	{

	}

	/**
	 * Use to hold blocks which are associated with a particular request
	 */
	protected $_blocks = array();

	/**
	 * This action will render the entire view section that are added in the
	 * controller.
	 *
	 * @return  void
	 */
	public function render()
	{
		$blocks = $this->getAllBlock();
		foreach ($blocks as $name => $block) {
			$templatePath = $block->getTemplate();
			$templateFile = 'app/design/template/' . $templatePath;
			if (file_exists($templateFile)) {
				$block->toHtml();
			} else {
				throw new Exception('Template File ' .
					$templateFile . ' does not exist');

			}
		}
	}

	/**
	 * Use to get POST value.
	 *
	 * @param  string $reference
	 * @return mixed
	 */
	public function getPost($reference = '')
	{
		return Core_Http_Client::post($reference);
	}

	/**
	 * Use to get GET value.
	 *
	 * @param  string $reference
	 * @return mixed
	 */
	public function getParam($reference = '')
	{
		return Core_Http_Client::get($reference);
	}

	/**
	 * Use to check whether a POST request exist.
	 *
	 * @param  string  $reference
	 * @return boolean
	 */
	public function hasPost($reference = '')
	{
		return Core_Http_Client::hasPOST($reference);
	}

	/**
	 * Use to check whether a GET request exist.
	 *
	 * @param  string  $reference
	 * @return boolean
	 */
	public function hasParam($reference)
	{
		return Core_Http_Client::hasGET($reference);
	}

	/**
	 * Use to add a new block
	 *
	 * The type of the block is the reference for a valid block
	 * Every block should have a unique name. This way we can later refer
	 * a block and reutilize it.
	 *
	 * @param  string $type
	 * @param  string $name
	 * @return mixed
	 */
	public function addBlock($type = '', $name = '')
	{
		//if no block type specified, then use the default block type
		if ($type == '') {
			$type = 'core_default/index';
		}
		//if no name specified, then generate a unique name for the block
		if ($name == '') {
			$randomChars = App::getHelper()->getRandomCharacters(4);
			$name = 'random_block_' . $randomChars;
		}

		$block = App::getView($type);
		if ($block instanceof Core_Default_View_Abstract) {
			$this->_blocks[$name] = $block;
			return $block;
		} else {
			throw new Exception('The block with name' . $name . 'is not valid');
		}
	}

	/**
	 * Use to get a block
	 *
	 * @param  string $name
	 * @return mixed
	 */
	public function getBlock($name)
	{
		if (array_key_exists($name, $this->_blocks)) {
			return $this->_blocks[$name];
		} else {
			return false;
		}
	}

	/**
	 * Use to remove a block
	 *
	 * @param  string                           $name
	 * @return Core_Default_Controller_Abstract
	 */
	public function removeBlock($name)
	{
		unset($this->_blocks[$name]);
		return $this;
	}

	/**
	 * Use to get all blocks
	 *
	 * @return array
	 */
	public function getAllBlock()
	{
		return $this->_blocks;
	}
}
