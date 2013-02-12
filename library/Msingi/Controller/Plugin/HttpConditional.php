<?php

/**
 * Plugin to process HTTP conditionals
 *
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Controller_Plugin_HttpConditional extends Zend_Controller_Plugin_Abstract
{

	/**
	 * Process HTTP conditionals if allowed by settings
	 */
	public function dispatchLoopShutdown()
	{
		$settings = Zend_Registry::get('Settings');

		if ($settings->getBoolean('performance:html:conditional'))
		{
			// calculate Etag for content
			$etag = '"' . md5($this->getResponse()->getBody()) . '"';
			// set Etag header
			$this->getResponse()->setHeader('ETag', $etag, true);

			$inm = explode(',', getenv('HTTP_IF_NONE_MATCH'));
			foreach ($inm as $i)
			{
				if (trim($i) == $etag)
				{
					$this->getResponse()
							->clearAllHeaders()
							->setHttpResponseCode(304)
							->clearBody();
					break;
				}
			}
		}
	}

}