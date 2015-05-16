<?php
/**
 *....................................................................................
 *                                 BasicObject.php                                    *
 *....................................................................................*
 * 
 * This is a basic class which will be used by the entire module of the application.
 * Evrery file that comes directly under the class root directory will be a file that
 * is used by every classes in the framework
 * 
 * File     : BasicObject.php
 * contains : class
 * Location : app/class/BasicObject.php
 */

/**
 * BasicObject Class
 *
 * Every class will be inherited from this class basically. So this is the class which
 * you need to use to include those methods which are used by every type of class in 
 * the framework. Such a utiltiy is the magic methods.
 */

class BasicObject
{
	/**
	 * php default function __call()
	 *
	 * Use to set and get propeties of a class if that class is inheriting
	 * from this class. In another methods, it provides magic methods.
	 * 
	 * @param  string $methodname eg: setName(), getName()
	 * @param  array  $parameters 
	 * @return mixed 
	 */
	public function __call($methodname, $parameters)
	{
		if(strpos($methodname, 'set') !== false) {
			$property = ltrim($methodname, 'set');
			preg_match_all('/[A-Z][^A-Z]*/', $property, $results);
			$realProperty = implode('_', array_map(
				function($element) {
					return strtolower($element);
				}, 
				$results[0])
			);
			$this->$realProperty = $parameters[0];
			return $this;
		}

		if (strpos($methodname, 'get') !== false) {
			$property = ltrim($methodname, 'get');
			preg_match_all('/[A-Z][^A-Z]*/', $property, $results);
			$realProperty = implode('_', array_map(
				function($element) {
					return strtolower($element);
				}, 
				$results[0])
			);
			return $this->$realProperty;
		}

		return $this;
	}
}