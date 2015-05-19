<?php
/**
 *....................................................................................
 *                                 App.php                                           *
 * ..................................................................................*
 *
 * This is file is used to make life easier. In another way, this file holds more
 * complex and basic codes, but that makes logic seperation more simple and efficient.
 *
 * File     : App.php
 * contains : class
 * Location : app/class/App.php
 */

/**
 * App Class
 *
 * This is our application class. Most of the method holds by this class are static
 * methods. This means the purpose of the methods in this class to deliver some fixed
 * jobs.
 *
 * This class holds lot of reusable methods in it. Using those methods, we can
 * effectively get any object from anywhere.
 */
class App
{

	/**
	 * Application runner
	 *
	 * This function will figure out the right controller and action that is requested
	 * by the application and then execute it.
	 *
	 * namespace_module/some_controller => Namespace_Module_Controller_Some_Controller
	 * namespace_module                 => Namespace_Module_Controller_Index
	 * ''                               => Core_Default_Controller_Index
	 *
	 * @param  string  $controllerRef
	 * @param  mixed   $inputs
	 * @return boolean
	 */
	public static function run($controller = '', $action = '', $inputs = '')
	{
		try {
			if ($controller == '') {

				//find the relative path.
				$http = self::getClass('core_http/client')
					->setBaseUrl(self::getUrl());
				$relPath = trim($http->getRelativePath(), '/');

				//seperate router, controller and action.
				$routerRefArr = self::_makeRouterReferenceArray($relPath);
				if (count($routerRefArr) == 3) {
					list($router, $actionPath, $action) = $routerRefArr;
				} else {
					throw new Exception('Requested ation cannot be processed.');	
					die();
				}

				//find module using router
				$moduleConfigFile = self::_getConfigJsonFile('module_config');
				$modules = self::getClass('core_json/parser')
					->input($moduleConfigFile)->getConfigNode('modules');
				if ($moduleName = self::_findModuleByRouter($modules, $router) !== false) {
					$moduleRef = self::geneateUnderScoreCasedName(
						self::_findModuleByRouter($modules, $router)->name
					);
				} else {
					//means requested router is not part of a module.
					throw new Exception('Router :' . $router. ' does not exist.');
				}

				//find controller using action path.
				$controllerRef = self::geneateUnderScoreCasedName(
					self::_generateProperName($actionPath, '-')
				);

				//generate controller reference
				$controller = $moduleRef . '/' . $controllerRef;			
			}

			//make controller instance and then trigger the action.
			$controllerInstance = self::getController($controller);
			$action = self::generateActionName($action);
			if ($inputs != '') {
				$controllerInstance->$action($inputs);
			} else {
				$controllerInstance->$action();
			}
			
			return true;

		} catch (Exception $e) {
			self::_generateException($e);
		}
	}

	/**
	 * Use to get a controller object.
	 *
	 * Controller object are resoponsible for processing the request. They are normally
	 * resides in app/class/Namespace/Module/Controller directory. This function is used
	 * to get any controller class in the application.
	 *
	 * Eg: App::getController('namespace_module/some_Request') will deliver you isntance
	 * of the class `Namespace_Module_Controller_Some_Request` in
	 * `app/class/Namespace/Module/Controller/Some/Request.php`
	 *
	 * @param  string $view
	 * @return mixed
	 */
	public static function getController($controller = '')
	{
		try {
			$controllerClassName = self::generateClassName($controller, 'controller');
			$instance = new $controllerClassName();
		} catch (Exception $e) {
			self::_generateException($e);
		}

		return $instance;
	}

	/**
	 * Use to get a view object.
	 *
	 * View objects are used to show real outputs in front side. They are
	 * normally resides in app/class/Namespace/Module/View directory. This
	 * function is used to get any view class in the application.
	 *
	 * Eg: App::getView('namespace_module/some_view') will deliver you
	 * isntance of the class `Namespace_Module_View_Some_View` in
	 * `app/class/Namespace/Module/View/Some/View.php`
	 *
	 * @param  string $view
	 * @return mixed
	 */
	public static function getView($view = '')
	{
		try {
			$viewClassName = self::generateClassName($view, 'view');
			$instance = new $viewClassName();
		} catch (Exception $e) {
			self::_generateException($e);
		}

		return $instance;
	}

	/**
	 * Use to get a model object.
	 *
	 * Model objects are the entities of the application. They are normally
	 * resides in app/class/Namespace/Module/Model directory. This function
	 * is used to get any model class in the application.
	 *
	 * Eg: App::getModel('namespace_module/some_entity') will deliver you
	 * isntance of the class `Namespace_Module_Model_Some_Entity` in
	 * `app/class/Namespace/Module/Model/Some/Entity.php`
	 *
	 * @param  string $model
	 * @return mixed
	 */
	public static function getModel($model = '')
	{
		try {
			$modelClassName = self::generateClassName($model, 'model');
			$instance = new $modelClassName();
		} catch (Exception $e) {
			self::_generateException($e);
		}

		return $instance;
	}

	public static function getClass($class)
	{
		try {
			$className = self::generateClassName($class);
			$instance = new $className();
		} catch (Exception $e) {
			self::_generateException($e);
		}

		return $instance;
	}

	/**
	 * Use to get a helper object.
	 *
	 * Helper object holds some useful generic classes and methods. They are
	 * normally resides in app/class/Namespace/Module/Helper directory. This
	 * function is used to get any helper class in the application.
	 *
	 * Eg: App::getHelper('namespace_module/some_helper') will deliver you
	 * isntance of the class `Namespace_Module_Helper_Some_Helper` in
	 * `app/class/Namespace/Module/Helper/Some/Helper.php`
	 *
	 * @param  string $helper
	 * @return mixed
	 */
	public static function getHelper($helper = '')
	{
		try {
			$helperClassName = self::generateClassName($helper, 'helper');
			$instance = new $helperClassName();
		} catch (Exception $e) {
			self::_generateException($e);
		}

		return $instance;
	}

	/**
	 * Use to get a resource object.
	 *
	 * resource objects are that actually communicate with db. They are
	 * normally resides in app/class/Namespace/Module/Model/Resource
	 * directory. This function is used to get any resource class which resides
	 * in Model directory.
	 *
	 * Eg: App::getResource('namespace_module/some_resource') will deliver you
	 * isntance of the class `Namespace_Module_Model_Resource_Some_Resource` in
	 * `app/class/Namespace/Module/Model/Resource/Some/Resource.php`
	 *
	 * @param  string $helper
	 * @return mixed
	 */
	public static function getResource($resource = '')
	{
		try {
			$resourceClassName = self::generateClassName($resource, 'model_resource');
			$instance = new $resourceClassName();
		} catch (Exception $e) {
			self::_generateException($e);
		}

		return $instance;
	}

	/**
	 * get application url.
	 *
	 * @param  string $path
	 * @return string
	 */
	public static function getUrl($path = '')
	{
		$generalConfigFile = self::_getConfigJsonFile('general_config');
		$baseUrl = self::getClass('core_json/parser')->input($generalConfigFile)
			->getConfigNode('general/urls/base_url');
		return $baseUrl . $path;
	}

	/**
	 * Use to generate underscore_case name.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected static function geneateUnderScoreCasedName($name)
	{
		if ($name == '') {
			return '';
		}
		$modifiedName = implode('_', array_map(
			function($element) {
				return lcfirst($element);
			},
			explode('_', $name)
		));
		return $modifiedName;
	}
	/**
	 * Use to modify the name in the class name way
	 *
	 * ie some_thing_in_this format => Some_Thing_In_This_Format
	 *
	 * @param  string $classname
	 * @return string $modifiedName
	 */
	protected static function _generateProperName($classname, $seperator = '_')
	{
		if ($classname == '') {
			return '';
		}
		$modifiedName = implode('_', array_map(
			function($element) {
				return ucfirst($element);
			},
			explode($seperator, $classname)
		));
		return $modifiedName;
	}

	/**
	 * Use to generate a valid class name from the given string.
	 *
	 * @param  string $classname
	 * @param  string $section
	 * @return string $CLASS
	 */
	protected static function generateClassName($classname = '', $section = '')
	{
		//seperating module if it exist
		if (strpos($classname, '/') !== false) {
			$namespacePlusClass = explode('/', $classname);
			$moduleRef = explode('_', $namespacePlusClass[0]);
			if (count($moduleRef) == 2) {
				$namespaceModule = $namespacePlusClass[0];
			} elseif (count($moduleRef) == 1) {
				$namespaceModule = 'core_' . $namespacePlusClass[0];
			}
			$module = self::_generateProperName($namespaceModule);
			$class = self::_generateProperName($namespacePlusClass[1]);

		//no module in request, so use the default module.
		} elseif ($classname != '') {
			$module = 'Core_Default';
			$class = self::_generateProperName($classname);

		//so no module, class specification in request. So go on with defaul class.
		} else {
			$module = 'Core_Default';
			$class = 'Index';
		}

		$realSection = self::_generateProperName($section);
		if ($realSection == '') {
			$CLASS = $module . '_' . $class;
		} else {
			$CLASS = $module . '_' . $realSection . '_' . $class;
		}
		return $CLASS;
	}

	/**
	 * Use to generate an action name
	 *
	 * eg : post_login =>  LoginPost
	 *
	 * @param  string $action
	 * @return string $modifiedName
	 */
	protected static function generateActionName($action = '')
	{
		//default action is index.
		if ($action == '') {
			$action = 'index';
			return 'Index';
		}

		$modifiedName = implode('', array_map(
			function($element) {
				return ucfirst($element);
			},
			explode('_', $action)
		));
		return $modifiedName;
	}

	/**
	 * Use to generate exception
	 *
	 */
	protected static function _generateException(Exception $e)
	{
		echo $e->getMessage() . ' in ' . '`' . $e->getFile() .'(' . $e->getLine() . ')`';
		die();
	}

	/**
	 * Use to generate router reference array
	 *
	 * Router reference array looks like
	 *
	 *   array (
	 *      $router, $controller-path, $action
	 *   )
	 *   
	 * @param  string $reference
	 * @return array
	 */
	protected static function _makeRouterReferenceArray($reference)
	{
		//no router, controller and action
		if (count(explode('/', $reference)) == 0) {
			$routerRefArr = array('default', 'index', 'index');

		//router exist. no controller and action
		} elseif (count(explode('/', $reference)) == 1) {
			$routerRefArr = explode('/', $reference);
			$routerRefArr = array_merge($routerRefArr, array('index', 'index'));
				
		//router and controller exist. But not action.
		} elseif (count(explode('/', $reference)) == 2) {
			$routerRefArr = explode('/', $reference);
			$routerRefArr = array_merge($routerRefArr, array('index'));

		//a router, controller and an action does exist.
		} elseif (count(explode('/', $reference)) == 3) {
			$routerRefArr = explode('/', $reference);
		} else {
			$routerRefArr = false;
		}

		return $routerRefArr;
	}

	/**
	 * Use to get a json configuration file based on it's key.
	 *
	 * @param  string $fileKey
	 * @return string
	 */
	protected static function _getConfigJsonFile($fileKey)
	{
		$jsonParser = new Core_Json_Parser('app/config/json/basic.json');
		$configFiles = $jsonParser
			->getConfigNode('config_files');
		foreach ($configFiles as $fileObj) {
			if (isset($fileObj->general_config)) {
				$configFile = $fileObj->$fileKey;
			}
		}

		return $configFile;
	}

	/**
	 * Use to find the module based on the router.
	 * 
	 * @param  array    $modules  Module list.
	 * @param  string   $router
	 * @return StdClass | boolean
	 */
	protected static function _findModuleByRouter($modules, $router)
	{
		foreach ($modules as $moduleRefObj) {
			$moduleKeyArray = get_object_vars($moduleRefObj);
			foreach ($moduleKeyArray as $realModule) {
				if ($realModule->router == $router) {
					return $realModule;
				}
			}
		}

		return false;
	}
}