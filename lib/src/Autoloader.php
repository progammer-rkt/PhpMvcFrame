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
 * @package    Core_Default
 * @copyright  Copyright (c) 2015
 */

/**
 * Autoloader Class
 *
 * This class is used to handle autloading of classes and interface.
 *
 * This file holds the autoloading functionality of the framework. Autolader came
 * into action when the application tries to load a class or an interface.
 *
 * Classes are resides in the directory /app/class. This framework works in such a
 * way that, you should construct your application using small, big modules.
 * A module is used to implement a specific functionality in the application.
 * It is recommended that every module is independent of each other. A module should
 * be named like `Namespace_Modulename`. eg: Core_Customer, Demo_Fundraiser etc.
 *
 * Every module may posses  basically four logical sections. They are View, Model,
 * Helper and Controller. The model again split into Resource in order to hold
 * database quries.
 *
 * @category Core
 * @package  Core_Default
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Autoloader
{

	/**
	 * Use to autoload framework classes.
	 *
	 * @param string $class
	 */
	public static function AutoloadMe($class)
	{
		$fileName = self::generateClassFileName($class);
		$classFile = 'app/class/' . $fileName;
		$libraryFile = 'lib/src/' . $fileName;
		if (file_exists($classFile)) {
			include_once  $classFile;
		} elseif (file_exists($libraryFile)) {
			include_once  $libraryFile;
		} else {
			throw new Exception("Class : " . $class . " Not Found");
		}
	}

	/**
	 * Use to generate a file name from the given string.
	 *
	 * @param  string $fileRef
	 * @return string $file
	 */
	protected static function generateClassFileName($fileRef)
	{
		$classArray = explode('_', $fileRef);
		$ucClassArray = array_map(
			function($element) {
				return ucfirst($element);
			},
			$classArray
		);
		$class = implode('/', $ucClassArray);
		$file = $class . '.php';

		return  $file;
	}
}

/**
 * Default Autoloading caller
 */
spl_autoload_register('Autoloader::AutoloadMe');