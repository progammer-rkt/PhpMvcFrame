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
  * Core_Default_View_Abstract Class
  *
  * This is the parent class of all models. So this class will hold all common
  * utilities which are used by every other models in the application.
  *
  * @category Core
  * @package  Core_Default
  * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
  */
class Core_Default_View_Abstract extends BasicObject
{
	/**
	 * Use to set the template
	 *
	 * @var string
	 */
	protected $_template = '';

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->setTemplate($this->_template);
	}

	/**
	 * Use set a template for the view.
	 *
	 * @param string                      $template
	 * @return Core_Default_View_Abstract
	 */
	public function setTemplate($template)
	{
		$this->_template = $template;
		return $this;
	}

	/**
	 * Use to get the template
	 *
	 * @return string
	 */
	public function getTemplate()
	{
		return $this->_template;
	}

	/**
	 * Use to output block
	 *
	 * @return Core_Default_View_Abstract
	 */
	public function toHtml()
	{
		require_once 'app/design/template/' . $this->getTemplate();
		return $this;
	}
}