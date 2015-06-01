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
 * Vitual Model Abstract class
 *
 * This special model abstract class is used for virtual database models. Virtual
 * database is not actual databases. So a virtual database is normally using for
 * testing, demonstration etc. For those models which are act as virtual enity, will
 * inherit from this abstract class so that they can use the methods which are
 * specifically designed for virtual models.
 *
 * @category Core
 * @package  Core_Default
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Core_Default_Model_Virtual_Abstract extends Core_Default_Model_Abstract
{

	/**
	 * Use to get all entities from the table.
	 *
	 * @return array $all
	 */
	public function getAll()
	{
		$all = array();
		$collection = $this->_collection;
		$helper = App::getHelper();

		foreach ($collection as $key => $entity) {
			$frTableInstance = $this->getResource();
			foreach ($entity as $property => $value) {
				$set = 'set' . $helper->generateGetSetName($property);
				$frTableInstance->$set($value);
			}
			$all[] = clone $frTableInstance;

		}

		return $all;
	}

	/**
	 * Use to load an entity.
	 *
	 * @param  int  $id
	 * @return mixed Core_Default_Model_Resource_Abstract | boolean
	 */
	public function load($id)
	{
		$collection = $this->_collection;
		$helper = App::getHelper();

		foreach ($collection as $item) {
			if ($item['id'] == $id) {
				$frTableInstance = $this->getResource();
				foreach ($item as $property => $value) {
					$set = 'set' . $helper->generateGetSetName($property);
					$frTableInstance->$set($value);
				}
				return $frTableInstance;
			}
		}
		return false;
	}
}