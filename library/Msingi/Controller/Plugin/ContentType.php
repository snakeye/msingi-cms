<?php

class Msingi_Controller_Plugin_ContentType extends Zend_Controller_Plugin_Abstract
{

	/**
	 *
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