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
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * This is the entry point to the demo framework. The framework is constructed in
 * such a way that, we can enter into the domo section only through this file.
 */

/**
 * Use to set in developer mode or in production mode.
 */
$develper_mode = 1;
if ($develper_mode == 1) {
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', 1);
}

include 'lib/src/Autoloader.php'; //here is automatic autoloading of classes takes
                                  //place.
include 'app/config/basic.php'; //basic configuraton files. global variables here
include 'app/App.php';  //application is run by this file. Lot of utility functions
                        //in your hand.

/**
 * Use to run the demo application
 *
 * run () method can accept three params
 *  	param 1: defines the controller that need to used
 *  	param 2: defines the action that need to trigger from controller.
 *      param 3: defines params that need to pass to the action.
 */
try {
	App::run('');
} catch (Exception $e) {
	echo $e->getMessage();
	die();
}