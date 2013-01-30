<?php

class Msingi_Router_SingleLanguage extends Msingi_Router
{

	/**
	 *
	 * @param Zend_Controller_Request_Abstract $request
	 * @throws Zend_Controller_Router_Exception
	 * @return Zend_Controller_Request_Abstract Request object
	 */
	public function route(Zend_Controller_Request_Abstract $request)
	{
		//
		if ($request instanceof Msingi_Controller_Request)
		{
			$request->setSection($this->_currentSection);

			//
			$language = Msingi_Model_Settings::getInstance()->get('section:' . $this->_currentSection->name() . ':languages:default', 'en');

			//
			$languages = new Msingi_Model_Constants_Languages();

			//
			$this->initLocale($languages->getLocale($language));

			// get request uri
			$uri = $request->getRequestUri();

			// check we have content page
			$pages = new Msingi_Model_Pages_PagesTable();
			$page = $pages->fetchByPath($uri);
			if ($page != null)
			{
				// add default routes
				$this->addDefaultRoutes();

				$this->_setRequestParams($request, array(
					'module' => 'default',
					'controller' => 'page',
					'action' => 'index',
					'__page' => $page
				));

				return $request;
			}
		}

		return parent::route($request);
	}

}