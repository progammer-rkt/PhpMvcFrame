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
 * @package    Core_Object
 * @copyright  Copyright (c) 2015
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Core Object Entity class
 *
 * This class is used by SimpleMage to set random propeties and access in terms of
 * class basis. In another words, it is a class which is like a defautl `stdClass`
 * in php except that it has special get, set methods to grab it's properties.
 *
 * @category Core
 * @package  Core_Object
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Core_Object_Entity
{

	/**
	 * Use to set a data on this object.
	 *
	 * @param array $data
	 */
	public function setData($data)
	{
		foreach ($data as $property => $value) {
			$this->$property = $value;
		}
		return $this;
	}

	/**
	 * Use to get a data from this object
	 *
	 * If nothing is passed, it will return all data. Otherwise requested data.
	 *
	 * @param  mixed $data
	 * @return mixed
	 */
	public function getData($data = null)
	{
		if (is_null($data)) {
			return get_object_vars($this);
		} else {
			return $this->$data;
		}
	}

	/**
	 * php default function __call()
	 *
	 * Use to set and get propeties of a class if that class is inheriting
	 * from this class. In another methods, it provides magic methods.
	 *
	 * @param  string     $methodname    eg: setName(), getName()
	 * @param  array      $parameters
	 * @throws Exception
	 * @return mixed
	 */
	public function __call($methodname, $parameters)
	{
		if(strpos($methodname, 'set') !== false) {
			$realProperty = $this->_getRealProperty($methodname);
			$this->$realProperty = $parameters[0];
			return $this;
		}

		if (strpos($methodname, 'get') !== false) {
			$realProperty = $this->_getRealProperty($methodname);
			return $this->$realProperty;
		}

		if (strpos($methodname, 'has') !== false) {
			$realProperty = $this->_getRealProperty($methodname);
			return isset($this->$realProperty);
		}

		throw new Exception('Method : ' . $methodname . '() Does not exist.');
	}

	/**
	 * Use to get the property from the method name.
	 *
	 * @param  string $method
	 * @return string $realProperty
	 */
	protected function _getRealProperty($method)
	{
		$property = ltrim($method, 'set');
		preg_match_all('/[A-Z][^A-Z]*/', $property, $results);
		$realProperty = implode('_', array_map(
			function($element) {
				return strtolower($element);
			},
			$results[0])
		);

		return $realProperty;
	}
}