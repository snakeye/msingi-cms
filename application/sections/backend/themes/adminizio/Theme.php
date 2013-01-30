<?php

class ThemeAdminizio
{

	/**
	 *
	 * @param Msingi_View $view
	 * @return Msingi_View
	 */
	public function init($view)
	{
		//
		$view->navigation($view->moduleMenu('main'));

		//
		$view->headLink()->appendStylesheet($view->assets() . '/css/reset.css');
		$view->headLink()->appendStylesheet($view->assets() . '/css/main.css');
		$view->headLink()->appendStylesheet($view->assets() . '/css/style.css');

		$view->headLess()->appendStylesheet($view->assets() . '/css/mystyle.less');

		return $view;
	}

}