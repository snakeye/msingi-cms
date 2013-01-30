<?php

class Msingi_Controller_Plugin_HttpConditional extends Zend_Controller_Plugin_Abstract
{

	public function dispatchLoopShutdown()
	{
		$settings = Zend_Registry::get('Settings');

		if ($settings->getBoolean('performance:html:conditional'))
		{
			$etag = '"' . md5($this->getResponse()->getBody()) . '"';
			$this->getResponse()->setHeader('ETag', $etag, true);

			$inm = explode(',', getenv('HTTP_IF_NONE_MATCH'));
			foreach ($inm as $i)
			{
				if (trim($i) == $etag)
				{
					$this->getResponse()->clearAllHeaders()->setHttpResponseCode(304)->clearBody();
					break;
				}
			}
		}
	}

}