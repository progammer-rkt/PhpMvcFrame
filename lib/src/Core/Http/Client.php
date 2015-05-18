<?php
/**
 * ...................................................................................
 *                                 Client.php                                         *
 * ...................................................................................*
 *
 * This file is a part of the package Core_Http. This package is the part of this
 * framework. This package is used for controlling HTTP Requests in better way.
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

}