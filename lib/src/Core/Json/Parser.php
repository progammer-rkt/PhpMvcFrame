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
 * @package    Core_Json
 * @copyright  Copyright (c) 2015
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Core_Json_Parser Class
 *
 * This class is used to parse json and provide some super cool php utility functions.
 *
 * @category Core
 * @package  Core_Json
 * @author   Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Core_Json_Parser extends BasicObject
{

	/**
	 * Use to hold the content of json file.
	 *
	 * @var string
	 */
	protected $_json = '';

	/**
	 * Constructor
	 *
	 * Use to set a json file that need to parse
	 *
	 * @param string $jsonfile
	 * @return Core_Json_Parser
	 */
	public function __construct($jsonfile = '')
	{
		$this->input($jsonfile);
		return $this;
	}

	/**
	 * Use to get the json.
	 *
	 * @return string
	 */
	public function getJson()
	{
		return json_encode($this->_json);
	}

	/**
	 * Use to input json by json file.
	 *
	 * @param  string $jsonfile
	 * @return Core_Json_Parser
	 */
	public function input($jsonfile)
	{
		if (file_exists($jsonfile)) {
			$this->_json = json_decode(file_get_contents($jsonfile));
		}
		return $this;
	}

	/**
	 * Use to set json.
	 *
	 * @param string $json
	 * @return  Core_Json_Parser
	 */
	public function setJson($json)
	{
		if (is_string($json)) {
			$this->_json = json_decode($json);
		}
		return $this;
	}

	/**
	 * Use to get configuration node value.
	 *
	 * @param  string $node
	 * @return mixed
	 */
	public function getConfigNode($node = '')
	{
		if ($node == '') {
			return $this->_json->config;
		}
		$configPath = $this->_json->config;
		$nodes = explode('/', $node);
		foreach ($nodes as $path) {
			if (isset($configPath->$path)) {
				$configPath = $configPath->$path;
			} else {
				throw new Exception('Wrong Node : ' . $node . ' is given.');
			}
		}
		return $configPath;
	}
}