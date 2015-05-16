<?php
/**
 *....................................................................................
 *                                 basic.php                                          *
 * ...................................................................................*
 * 
 * This is a configuration file. Configuration files are special files which are used
 * to set different configurations that should use in different part of the framework.
 * 
 * File     : basic.php
 * contains : basic php
 * Location : app/config/basic.php
 */

/**
 * This array is used to hold special autoloading classes when deal with special
 * classes. There will be some occasions where we need to travel from the "common
 * way".
 */
$_class = array(
	'required' => array(
		'BasicObject' => 'app/class/BasicObject.php'
	)
);

foreach ($_class as $key => $value) {
	
	//include required classes
	if ($key == 'required') {
		$requiredClasses = $_class['required'];
		foreach ($requiredClasses as $requiredClass => $classLocation) {
			include_once $classLocation;
		}
	}
}

/**
 * If you have other configuration file other than this, then add an entry for it 
 * here. It will automatically loaded in the application and thus you can utilize
 * your custom configuration in effective way.
 */
$_conifFiles = array(
 	//'custom' => 'some/custom.php'
);

foreach ($_conifFiles as $key => $value) {
	include_once 'app/config/' . $value;
}