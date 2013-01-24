<?php

class Msingi_Controller_Plugin_CacheControl extends Zend_Controller_Plugin_Abstract
{

	/**
	 *
	 */
	public function dispatchLoopShutdown()
	{
		$response = $this->getResponse();

		if ($response instanceof Msingi_Controller_Response)
		{
			if ($response->getCacheControl())
			{
				$response->setHeader('Pragma', '', true);
				$response->setHeader('Expires', gmdate('D, d M Y H:i:s', time() + $response->getCacheLifetime()) . ' GMT', true);
				$response->setHeader('Cache-Control', 'public, must-revalidate, max-age=' . $response->getCacheLifetime(), true);
			}
			else
			{
				$response->setHeader('Pragma', 'no-cache', true);
				$response->setHeader('Cache-Control', 'no-cache', true);
				$response->setHeader('Expires', gmdate('D, d M Y H:i:s', time() - 1) . ' GMT', true);
			}
		}
	}

}