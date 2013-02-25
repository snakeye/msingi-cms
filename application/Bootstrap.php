<?php

/**
 * Application bootstrap
 *
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Bootstrap extends Msingi_Application_Bootstrap
{

	/**
	 * Initialize routes
	 *
	 * @return Msingi_Router
	 */
	protected function _initRouter()
	{
		$router = parent::_initRouter();

		// add your routes here

		return $router;
	}

}