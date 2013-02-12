<?php

/**
 * Plugin to add content type if missing
 *
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Controller_Plugin_ContentType extends Zend_Controller_Plugin_Abstract
{

	/**
	 * Add content type header if missing one
	 */
	public function dispatchLoopShutdown()
	{
		foreach ($this->getResponse()->getHeaders() as $header)
		{
			if ($header['name'] == 'Content-Type')
			{
				return;
			}
		}

		$this->getResponse()->setHeader('Content-Type', 'text/html; charset=UTF-8');
	}

}