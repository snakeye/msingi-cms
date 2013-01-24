<?php

/**
 *
 */
class Msingi_View_Helper_Settings extends Zend_View_Helper_Abstract
{

	public function settings()
	{
		return Msingi_Model_Settings::getInstance();
	}

}