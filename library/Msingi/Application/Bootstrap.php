<?php

/**
 *
 * @package Msingi
 * @author Spectraweb s.r.o.
 */
class Msingi_Application_Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	/**
	 * Set internal encoding for PHP
	 */
	protected function _initInternalEncoding()
	{
		mb_internal_encoding("UTF-8");
	}

	/**
	 * Use custom autoloader
	 *
	 * @return \Zend_Loader_Autoloader
	 */
	protected function _initAutoload()
	{
		require_once 'Zend/Loader.php';

		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->setFallbackAutoloader(true);

		return $autoloader;
	}

	/**
	 *
	 */
	protected function _initPluginCache()
	{
		$this->bootstrap(array('Dir'));

		$dir = $this->getResource('Dir');

		$classFileIncCache = $dir->temp . '/pluginLoaderCache.php';
		if (file_exists($classFileIncCache))
		{
			include_once $classFileIncCache;
		}

		Zend_Loader_PluginLoader::setIncludeFileCache($classFileIncCache);
	}

	/**
	 * Application Settings
	 *
	 * @return Msingi_Model_Settings
	 */
	protected function _initSettings()
	{
		// require database and cache before access to settings
		$this->bootstrap(array('Db', 'Cache'));

		$settings = Msingi_Model_Settings::getInstance();

		$timezone = $settings->get('application:timezone');
		if ($timezone != '')
		{
			date_default_timezone_set($timezone);
		}

		Zend_Registry::set('Settings', $settings);

		return $settings;
	}

	/**
	 * Front controller init
	 *
	 * @return \Zend_Controller_Front
	 */
	protected function _initFrontController()
	{
		//
		$front = Zend_Controller_Front::getInstance();

		//
		$front->registerPlugin(new Msingi_Controller_Plugin_ViewScripts());

		// add cache control headers
		$front->registerPlugin(new Msingi_Controller_Plugin_CacheControl());

		// fix content type if not set
		$front->registerPlugin(new Msingi_Controller_Plugin_ContentType());

		// minify html
		$front->registerPlugin(new Msingi_Controller_Plugin_Minify());

		// add conditional ETag
		$front->registerPlugin(new Msingi_Controller_Plugin_HttpConditional());

		return $front;
	}

	/**
	 *
	 * @return \Msingi_View
	 */
	protected function _initView()
	{
		$view = new Msingi_View($this->getOptions());

		// msingi view helpers
		$view->addHelperPath('Msingi/View/Helper', 'Msingi_View_Helper_');
		// application view helpers
		$view->addHelperPath('View/Helper', 'View_Helper_');

		// Add it to the ViewRenderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setView($view);

		return $view;
	}

	/**
	 *
	 * Enter description here ...
	 */
	protected function _initRequest()
	{
		// Retrieve the front controller from the bootstrap registry
		$this->bootstrap(array('FrontController', 'Sections'));
		$front = $this->getResource('FrontController');
		$site = $this->getResource('Sections');

		// create request object
		$request = new Msingi_Controller_Request();
		$request->setSection($site->getCurrentSection());

		//
		$front->setRequest($request);

		// Ensure the request is stored in the bootstrap registry
		return $request;
	}

	/**
	 *
	 * @return type
	 */
	protected function _initResponse()
	{
		// Retrieve the front controller from the bootstrap registry
		$this->bootstrap(array('FrontController', 'Settings', 'Request'));

		$front = $this->getResource('FrontController');
		$settings = Zend_Registry::get('Settings');

		// create request object
		$response = new Msingi_Controller_Response();

		// set cache controll options
		$cache_control_enabled = $settings->get('performance:html:cache_control_enabled', false);
		$cache_control_lifetime = $settings->get('performance:html:cache_control_lifetime', 0);
		$response->setCacheControl($cache_control_enabled, $cache_control_lifetime);

		//
		$front->setResponse($response);

		// Ensure the request is stored in the bootstrap registry
		return $response;
	}

	/**
	 * Init application router
	 */
	protected function _initRouter()
	{
		$this->bootstrap(array('FrontController', 'Sections', 'Settings'));

		$front = $this->getResource('FrontController');
		$sections = $this->getResource('Sections');

		$currentSection = $sections->getCurrentSection();

		$settings = Msingi_Model_Settings::getInstance();

		$section_type = $settings->get('section:' . $currentSection->name() . ':languages:type', 'single');

		if ($section_type == 'multi')
			$router = new Msingi_Router_MultiLanguage();
		else
			$router = new Msingi_Router_SingleLanguage();

		$router->setCurrentSection($currentSection);

		$front->setRouter($router);

		return $router;
	}

	/**
	 *
	 */
	protected function _initTheme()
	{
		$this->bootstrap('Sections', 'Settings', 'View');
		$sections = $this->getResource('Sections');

		// get current section
		$currentSection = $sections->getCurrentSection();

		// settings
		$settings = Msingi_Model_Settings::getInstance();

		//
		$theme_name = $settings->get('section:' . $currentSection->name() . ':appearance:theme', 'default');

		// create theme
		$theme = new Msingi_Theme($theme_name);

		// store theme in registry
		Zend_Registry::set('Theme', $theme);

		//
		$view = $this->getResource('View');

		//
		$theme_path = sprintf('%s/sections/%s/themes/%s/', APPLICATION_PATH, $currentSection->name(), $theme->name());

		if (file_exists($theme_path . '/Theme.php'))
		{
			include_once $theme_path . '/Theme.php';

			//
			$name = strtolower('Theme ' . $theme->name());
			$name = str_replace(array('-', '.'), ' ', $name);
			$name = ucwords($name);
			$name = str_replace(' ', '', $name);

			//
			if (class_exists($name))
			{
				$theme_bootstrap = new $name();
				$theme_bootstrap->init($view);
			}
		}

		return $theme;
	}

	/**
	 *
	 * @return type
	 */
	protected function _initLayout()
	{
		$this->bootstrap('Sections', 'Settings', 'Theme');
		$sections = $this->getResource('Sections');
		$theme = $this->getResource('Theme');

		$currentSection = $sections->getCurrentSection();

		$layout = Zend_Layout::startMvc();

		$layoutsPath = sprintf('%s/sections/%s/themes/%s/layouts', APPLICATION_PATH, $currentSection->name(), $theme->name());

		$layout->setLayoutPath($layoutsPath);

		$layout->setLayout('default');

		return $layout;
	}

}