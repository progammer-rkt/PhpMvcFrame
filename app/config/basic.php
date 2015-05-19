<?php
/**
 * ...................................................................................
 *                                 basic.php                                          *
 * ...................................................................................*
 *
 * This is a configuration file. Configuration files are special files which are used
 * to set different configurations that should use in different part of the framework.
 *
 * File     : basic.php
 * contains : PHP
 * Location : app/config/basic.php
 */

$jsonParser = new Core_Json_Parser('app/config/json/basic.json');

/**
 * This array is used to hold special autoloading classes when deal with special
 * classes. There will be some occasions where we need to travel from the "common
 * way".
 */
$_Class = $jsonParser->getConfigNode('required_files');

foreach ($_Class as $fileObj) {
	include_once $fileObj->location;
}