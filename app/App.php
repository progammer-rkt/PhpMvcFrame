<?php
/**
 * App.php
 *
 * This is file is used to make life easier. In another way, this file
 * holds more complex and basic codes, but that makes logic seperation
 * more simple and efficient.
 *
 * File     : App.php
 * contains : class
 * Location : app/class/App.php
 */

/**
 * App Class
 *
 * This is our application class. Most of the method holds by this class
 * are static methods. This means the purpose of the methods in this class
 * to deliver some fixed jobs. 
 *
 * This class holds lot of reusable methods in it. Using those methods, we 
 * can effectively get any object from anywhere.
 */
class App
{

	/**
	 * Application runner
	 *
	 * This function will figure out the right controller and action
	 * that is requested by the application and then execute it.
	 * 
	 * namespace_module/some_controller => Namespace_Module_Controller_Some_Controller
	 * namespace_module => Namespace_Module_Controller_Index
	 * ''  => Core_Default_Controller_Index
	 * 
	 * @param  string $controllerRef
	 * @param  mixed  $inputs
	 * @return void
	 */
	public static function run($controller = '', $action = '', $inputs = '')
	{
		try {
			$controllerInstance = self::getController($controller);
			$action = self::generateActionName($action);
			if ($inputs != '') {
				$controllerInstance->$action($inputs);
			}
			$controllerInstance->$action();

		} catch (Exception $e) {
			self::_generateException($e);
		}
	}

	/**
	 * Use to get a controller object.
	 *
	 * Controller object are resoponsible for processing the request. They are 
	 * normally resides in app/class/Namespace/Module/Controller directory. This 
	 * function is used to get any controller class in the application.
	 *
	 * Eg: App::getController('namespace_module/some_Request') will deliver you 
	 * isntance of the class `Namespace_Module_Controller_Some_Request` in 
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
			$self::_generateException($e);
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
			$self::_generateException($e);
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
			$self::_generateException($e);
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
			$self::_generateException($e);
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
			$self::_generateException($e);
		}
		
		return $instance;
	}

	/**
	 * Use to modify the name in the class name way
	 * 
	 * ie some_thing_in_this format => Some_Thing_In_This_Format
	 * 
	 * @param $classname
	 * @return string
	 */
	protected static function _generateProperName($classname)
	{
		$modifiedName = implode('_', array_map(
			function($element) {
				return ucfirst($element);
			},
			explode('_', $classname)
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
		$CLASS = $module . '_' . $realSection . '_' . $class;
		return $CLASS;
	}

	/**
	 * Use to generate an action name
	 * 
	 * eg : post_login =>  LoginPost
	 * 
	 * @param  $action 
	 * @return $modifiedName
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
}