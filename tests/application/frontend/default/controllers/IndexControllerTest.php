<?php

require_once realpath(dirname(__FILE__) . '/../../../ControllerTestCase.php');

/**
 * @package MsingiTests
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class IndexControllerTest extends ControllerTestCase
{

	/**
	 * Test index page
	 */
	public function testIndex()
	{
		$this->dispatch('/');
		$this->assertSection('frontend');
		$this->assertModule('default');
		$this->assertController('index');
		$this->assertAction('index');
	}

	/**
	 * Test 404 error page
	 */
	public function test404()
	{
		$this->dispatch('/en/error404');
		$this->assertSection('frontend');
		$this->assertModule('default');
		$this->assertController('error');
		$this->assertAction('error');
		$this->assertResponseCode(404);
	}

}
