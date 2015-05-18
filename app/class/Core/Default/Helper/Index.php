<?php
/**
 *....................................................................................
 *                                 Index.php                                         *
 * ..................................................................................*
 *
 * This is a helper class. A helper class is used to hold helpful properties and
 * functions which can be used by other logic sections such as model, view, contoller
 * etc. Helpful methods and or properties will be something that will do a single job
 * for you.
 *
 * File     : Index.php
 * contains : class
 * Location : app/class/Helper/Index.php
 */

/**
 * Core_Default_Helper_Index Class
 *
 * This is the default helper class. Feel free to update this helper with useful
 * common helper methods that can be used by entire modules in the application.
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
