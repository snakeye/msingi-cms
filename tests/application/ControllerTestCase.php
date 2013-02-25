<?php

require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

/**
 * @package MsingiTests
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{

	/**
	 * @var Zend_Application
	 */
	protected $application;

	public function __construct()
	{
		$this->bootstrap = array($this, 'appBootstrap');
	}

	/**
	 *
	 */
	public function appBootstrap()
	{
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
		$this->application = new Zend_Application(APPLICATION_ENV, array_merge($config->toArray(), $app_defaults));

		$bootstrap = $this->application->bootstrap()->getBootstrap();

		$this->_frontController = $bootstrap->getResource('FrontController');
		$this->_request = $bootstrap->getResource('Request');
		//$this->_response = new Msingi_Controller_ResponseTestCase();
		//$this->_response = $bootstrap->getResource('Response');
	}

	/**
	 *
	 * @param type $section
	 * @param type $message
	 */
	public function assertSection($section, $message = '')
	{
		$this->_incrementAssertionCount();
		if ($section != $this->request->getSectionName())
		{
			$msg = sprintf('Failed asserting last section used <"%s"> was "%s"', $this->request->getSectionName(), $section);
			if (!empty($message))
			{
				$msg = $message . "\n" . $msg;
			}
			$this->fail($msg);
		}
	}

}
