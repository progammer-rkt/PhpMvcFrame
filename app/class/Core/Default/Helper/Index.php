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
 * Core_Default_Helper_Index Class
 *
 * This is the default helper class. Feel free to update this helper with useful
 * common helper methods that can be used by entire modules in the application.
 *
 * @category Core
 * @package  Core_Default
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>s
 */
class Core_Default_Helper_Index
{

	/**
	 * Use to geneate random characters based on the length provided.
	 *
	 * @param  int    $count
	 * @return string $s
	 */
	public function getRandomChars($length)
	{
		$s = substr(
			str_shuffle(
				str_repeat(
					"0123456789abcdefghijklmnopqrstuvwxyz", 5
			)), 0, $length);
		return $s;
	}

	/**
	 * Use to generate an action name
	 *
	 * eg : customer_name =>  CustomerName
	 *
	 * @param  string $property
	 * @return string $modifiedName
	 */
	public function generateGetSetName($property)
	{
		$modifiedName = implode('', array_map(
			function($element) {
				return ucfirst($element);
			},
			explode('_', $property)
		));
		return $modifiedName;
	}

}
