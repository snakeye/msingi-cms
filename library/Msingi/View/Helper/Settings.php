<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_View_Helper_Settings extends Zend_View_Helper_Abstract
{

	/**
	 *
	 * @return Msingi_Model_Settings
	 */
	public function settings()
	{
		return Msingi_Model_Settings::getInstance();
	}

}