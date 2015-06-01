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
 * @package    Core_Http
 * @copyright  Copyright (c) 2015
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 *
 * This file is a part of the package Core_Http. This package is the part of this
 * framework. This package is used for controlling HTTP Requests in better way.
 *
 * @category Core
 * @package  Core_Http
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */

class Core_Http_Client
{
	/**
	 * Use to store the base url.
	 *
	 * @var string
	 */
	protected $_baseUrl = '';

	/**
	 * Use to store the relative path.
	 *
	 * @var string
	 */
	protected $_relativePath = '';

	/**
	 * constructor
	 *
	 * @param  string            $baseUrl
	 * @return Core_Http_Client
	 */
	public function __construct($baseUrl = '')
	{
		$this->_baseUrl = $baseUrl;
		return $this;
	}

	/**
	 * Use to set base url
	 *
	 * @param string            $url
	 * @return Core_Http_Client
	 */
	public function setBaseUrl($url)
	{
		$this->_baseUrl = $url;
		return $this;
	}

	/**
	 * Use to get the relative path.
	 *
	 * @return string $relPath
	 */
	public function getRelativePath()
	{
		if ($this->_relativePath != '') {
			return $this->_relativePath;
		}
		$relUrlHolder = $_SERVER['REQUEST_URI'];
		$relArray = explode('/', $relUrlHolder);
		$baseArray = explode('/', $this->_baseUrl);
		foreach ($baseArray as $urlTerm) {
			if(($key = array_search($urlTerm, $relArray)) !== false) {
			    unset($relArray[$key]);
			}
		}
		if(($key = array_search('index.php', $relArray)) !== false) {
			unset($relArray[$key]);
		}

		$this->_relativePath = implode('/', $relArray);

		return $this->_relativePath;
	}

	/**
	 * Use to get POST value based on the reference.
	 *
	 * $_POST is an array
	 *
	 * @param  string $reference
	 * @return mixed
	 */
	public static function post($reference = '')
	{
		if($reference == '') {
			return $_POST;
		}
		return $_POST[$reference];
	}

	/**
	 * Use to get GET value based on the reference.
	 *
	 * $_GET is an array
	 *
	 * @param  string $reference
	 * @return mixed
	 */
	public static function get($reference = '')
	{
		if($reference == '') {
			return $_GET;
		}
		return $_GET[$reference];
	}


	/**
	 * Use to check whether a POST exist.
	 *
	 * $_POST is an array
	 *
	 * @param  string  $reference
	 * @return boolean
	 */
	public static function hasPOST($reference = '')
	{
		if ($reference == '') {
			if (count($_POST) == 0) {
				return false;
			} else {
				return true;
			}
		}
		return isset($_POST[$reference]);
	}

	/**
	 * Use to check whether a GET exist.
	 *
	 * $_GET is an array
	 *
	 * @param  string  $reference
	 * @return boolean
	 */
	public static function hasGET($reference = '')
	{
		if ($reference == '') {
			if (count($_GET) == 0) {
				return false;
			} else {
				return true;
			}
		}
		return isset($_GET[$reference]);
	}
}