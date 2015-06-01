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
 * Core_Default_View_Index_Index Class
 *
 * This class is the default view class. ie if the application is get run without
 * having a unique controller action request, then the application will eventually
 * look into this class for showing output in frontend.
 *
 * @category Core
 * @package  Core_Default
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com
 */
class Core_Default_View_Index_Index extends Core_Default_View_Index
{

	/**
	 * Use to set some custom content from the controller.
	 *
	 * @var string
	 */
	protected $content = '';

	/**
	 * Use to provide heading.
	 *
	 * @return  string $header
	 */
	public function Heading()
	{
		$header = 'SimpleMage Framework';
		return $header;
	}

	/**
	 * Use to return default content.
	 *
	 * @return  string $content
	 */
	public function DefaultContent()
	{
		$content = 'Welcome to SimpleMage Framework. A light-weight MVC framework in PHP'
			. ' that every Magento Developer need to use.';
		return $content;
	}
}