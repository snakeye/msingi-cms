<?php

/**
 * @package MsingiCms
 */

define('PUBLIC_PATH', realpath(dirname(__FILE__)));
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
define('LIBRARY_PATH', realpath(ROOT_PATH . '/library'));

defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', realpath(ROOT_PATH . '/application'));

// Define application environment
defined('APPLICATION_ENV')
	|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), LIBRARY_PATH,
		realpath(APPLICATION_PATH . '/library'),
		realpath(APPLICATION_PATH . '/models')
	)));

// add Msingi library to autoloader interface
require_once 'Zend/Loader/Autoloader.php';

$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Msingi_');

/** Zend_Application */
require_once 'Zend/Application.php';

// default applicaton settings
$app_defaults = array(
	'pluginPaths' => array(
		'Msingi_Application_Resource' => LIBRARY_PATH . '/Msingi/Application/Resource/',
		'Application_Resource' => APPLICATION_PATH . '/resources',
	),
	'bootstrap' => array(
		'path' => APPLICATION_PATH . '/Bootstrap.php',
		'class' => 'Bootstrap',
	),
);

// Load application config
$config = new Zend_Config_Ini(ROOT_PATH . '/config/app.ini', APPLICATION_ENV);

// create application
$application = new Zend_Application(APPLICATION_ENV, array_merge($config->toArray(), $app_defaults));

// bootstrap and run
try
{
	$application->bootstrap()->run();
}
catch (Exception $e)
{
	echo '<h1>Exception!</h1>';
	if (APPLICATION_ENV == 'development')
	{
		echo '<h3>' . get_class($e) . '</h3>';
		echo '<pre>' . $e->getMessage() . '</pre>';
		echo '<pre>' . $e->getTraceAsString() . '</pre>';
	}
}