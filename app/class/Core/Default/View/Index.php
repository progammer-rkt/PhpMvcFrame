<?php
/**
 * ..................................................................................
 *                                 Index.php                                         *
 * ..................................................................................*
 *
 * This is a view class. This view class is used by controllers to render the output
 * in frontend.
 *
 * File     : Index.php
 * contains : class
 * Location : app/class/Core/Default/View/Index.php
 */

 /**
  * Core_Default_View_Index Class
  *
  * This is the default view class of the framework. This is a general block class.
  * So if there is nothing specific with a block, then you can use this general
  * block.
  */
 class Core_Default_View_Index extends Core_Default_View_Abstract
 {
 	protected $_template = 'core/default/index/index.phtml';
 }