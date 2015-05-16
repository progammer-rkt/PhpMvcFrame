<?php
/**
 *....................................................................................
 *                                 Autoloader.php                                     *
 * ...................................................................................*
 * 
 * This file holds the autoloading functionality of the framework. Autolader came into
 * action when the application tries to load a class or an interface.
 * 
 * Classes are resides in the directory /app/class. This framework works in such a way
 * that, you should construct your application using small, big modules. A module is 
 * used to implement a specific functionality in the application. It is recommended
 * that every module is independent of each other. A module should be named like 
 * `Namespace_Modulename`. eg: Core_Customer, Demo_Fundraiser etc.
 * 
 * Every module may posses  basically four logical sections. They are View, Model,
 * Helper and Controller. The model again split into Resource in order to hold database
 * quries.
 */

/**
 * Autoloader Class
 * 
 * This class is used to handle autloading of classes and interface.
 */
class Autoloader
{

	public function AutoloadMe($class)
	{
		$classFile = $this->getFileNameFromClass($class);
		if (file_exists($classFile)) {
			include_once  $classFile;
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
		$file = 'app/class/' . ucfirst($section) . '/' . $class . '.php';

		return  $file;
	}

}

/**
 * 
 */
spl_autoload_register('Autoloader::AutoloadMe');