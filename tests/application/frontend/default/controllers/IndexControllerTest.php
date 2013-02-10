<?php

require_once realpath(dirname(__FILE__) . '/../../../ControllerTestCase.php');

class IndexControllerTest extends ControllerTestCase
{

	public function testIndex()
	{
		$this->dispatch('/');
		$this->assertSection('frontend');
		$this->assertModule('default');
		$this->assertController('index');
		$this->assertAction('index');
	}

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
