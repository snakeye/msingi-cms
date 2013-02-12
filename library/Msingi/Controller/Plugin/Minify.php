<?php

/**
 * Plugin to minify HTML code
 *
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Controller_Plugin_Minify extends Zend_Controller_Plugin_Abstract
{

	/**
	 *
	 */
	public function dispatchLoopShutdown()
	{
		$settings = Zend_Registry::get('Settings');

		if ($settings->getBoolean('performance:html:minify'))
		{
			$content_type = '';
			foreach ($this->getResponse()->getHeaders() as $header)
			{
				if ($header['name'] == 'Content-Type')
				{
					$content_type = explode(';', $header['value']);
					$content_type = $content_type[0];
					break;
				}
			}

			//
			if ($content_type == 'text/html' || $content_type == 'text/xhtml')
			{
				$html = Msingi_Util_MinifyHTML::minify($this->getResponse()->getBody());

				$this->getResponse()->setBody($html);
			}
		}
	}

}