<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Controller_Action_Helper_Redirector extends Zend_Controller_Action_Helper_Redirector
{

	public function gotoUrl($url, array $options = array())
	{
		parent::gotoUrl($url, $options);
	}

}