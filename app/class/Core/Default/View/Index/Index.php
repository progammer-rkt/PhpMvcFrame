<?php
/**
 * Index.php
 *
 * This is a view class. This view class is used by controllers to render
 * the output in frontend.
 *
 * File     : Index.php
 * contains : class
 * Location : app/class/View/Index/Index.php
 */

/**
 * IndexView Class
 *
 * This class is the default view class. ie if the application is get run
 * without having a unique controller action request, then the application
 * will eventually look into this class for showing output in frontend.
 */
class IndexView extends Viewer
{
	/**
	 * Use to set template for the view
	 * 
	 * @var string
	 */
	protected $template = 'index/index.phtml';
}