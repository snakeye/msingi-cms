<?php

/**
 * Theme initialization
 *
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class ThemeDefault
{

	/**
	 *
	 * @param Msingi_View $view
	 * @return Msingi_View
	 */
	public function init($view)
	{
		// set doctype
		$view->setDoctype('HTML5');

		// add favicon.ico
		$view->headLink(array('rel' => 'shortcut icon', 'href' => '/favicon.ico', 'type' => 'image/x-icon'), 'PREPEND');

		// use JQuery
		$view->headScript()->prependFile('//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');

		// bootstrap
		$view->headLink()->appendStylesheet($view->assets() . '/bootstrap/css/bootstrap.min.css');
		$view->headLink()->appendStylesheet($view->assets() . '/bootstrap/css/bootstrap-responsive.min.css');
		$view->headScript()->appendFile($view->assets() . '/bootstrap/js/bootstrap.js');

		// theme styles
		$view->headLess()->appendStylesheet($view->assets() . '/css/style.less');

		return $view;
	}

}