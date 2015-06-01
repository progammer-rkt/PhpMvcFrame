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
 * BasicObject Class
 *
 * Every class will be inherited from this class basically. So this is the class
 * which you need to use to include those methods which are used by every type of
 * class in the framework. Such a utiltiy is the magic methods.
 *
 * @category Core
 * @package  Core_Default
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class BasicObject
{

	/**
	 * Use to store data.
	 *
	 * @var Core_Object_Entity
	 */
	private $_data;

	/**
	 * Use to store a collection.
	 *
	 * @var array
	 */
	private $_collection = array();

	/**
	 * Use to set an array of data.
	 *
	 * @param   array        $data
	 * @throws  Exception
	 * @return  BasicObject
	 */
	public function setData($data)
	{

		if (is_array($data)) {
			foreach ($data as $field => $value) {
				$propName = implode('', array_map(function($parts) {
					return ucfirst($parts);
				}, explode('_', $field)));
				$method = 'set' . $propName;
				$this->$method($value);
			}
		} else {
			throw new Exception(
				'setData() is expecting an array as it\'s paramerter. `'
				. gettype($data)
				. '` is given.'
			);
		}
		return $this;
	}

	/**
	 * Use to get data.
	 *
	 * @return Core_Object_Entity
	 */
	public function getData()
	{
		return $this->_data;
	}

	/**
	 * Use to set an array of collection.
	 *
	 * @param   array        $collection
	 * @throws  Exception
	 * @return  BasicObject
	 */
	public function setBasicCollection($collection)
	{
		if (is_array($collection)) {
			foreach ($collection as $data) {
				$this->setData($data); //var_dump($this->getData());
				$this->_collection[] = $this->getData();
			}
		} else {
			throw new Exception(
				'setCollection() is expecting an array as it\'s paramerter. `'
				. gettype($data)
				. '` is given.'
			);
		}

		return $this;
	}

	/**
	 * Use to get collection
	 *
	 * @return array
	 */
	public function getBasicCollection()
	{
		return $this->_collection;
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
		if (!($this->_data instanceof Core_Object_Entity)) {
			$entity = new Core_Object_Entity();
			$this->_data = $entity;
		}

		if(strpos($methodname, 'set') !== false) {
			$realProperty = $this->_getRealProperty($methodname);
			$this->getData()->$realProperty = $parameters[0];
			return $this;
		}

		if (strpos($methodname, 'get') !== false) {
			$realProperty = $this->_getRealProperty($methodname);
			return $this->getData()->$realProperty;
		}

		if (strpos($methodname, 'has') !== false) {
			return $this->$methodname();
			$realProperty = $this->_getRealProperty($methodname);
			return isset($this->getData()->$realProperty);
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