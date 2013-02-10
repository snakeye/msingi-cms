<?php

error_reporting(E_ALL | E_STRICT);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../'));
define('LIBRARY_PATH', realpath(ROOT_PATH . '/library'));
define('PUBLIC_PATH', realpath(ROOT_PATH . '/public'));

// Define path to application directory
defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', realpath(ROOT_PATH . '/application'));

// Define application environment
defined('APPLICATION_ENV')
	|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(),
		LIBRARY_PATH,
		realpath(APPLICATION_PATH . '/library'),
		realpath(APPLICATION_PATH . '/models')
	)));

// add Msingi library to autoloader interface
require_once 'Zend/Loader/Autoloader.php';

$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Msingi_');

require_once 'Zend/Application.php';

require_once 'ControllerTestCase.php';
