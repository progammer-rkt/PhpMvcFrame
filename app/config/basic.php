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