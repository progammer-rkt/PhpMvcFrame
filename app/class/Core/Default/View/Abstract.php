<?php
/**
 * ..................................................................................
 *                                 Abstract.php                                      *
 * ..................................................................................*
 *
 * This is a view class. This view class is used by controllers to render the output
 * in frontend.
 *
 * File     : Abstract.php
 * contains : class
 * Location : app/class/Core/Default/View/Abstract.php
 */

 /**
  * Core_Default_View_Abstract Class
  *
  * This is the parent class of all models. So this class will hold all common
  * utilities which are used by every other models in the application.
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