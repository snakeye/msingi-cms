<?php

class Msingi_Router_MultiLanguage extends Msingi_Router
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
			$site = Zend_Registry::get('Sections');

			$request->setSection($site->getCurrentSection());
		}

		// get request uri
		$uri = $request->getRequestUri();
		// parse uri
		$parsed_uri = parse_url($uri);
		// split path
		$path = explode('/', trim($parsed_uri['path'], '/'));

		// get settings
		$available_languages = Msingi_Application_Settings::getInstance()->getArray('section:frontend:languages:enabled', array('en'));
		$default_language = Msingi_Application_Settings::getInstance()->get('section:frontend:languages:default', $available_languages[0]);

		//
		$language = (string) $path[0];

		$languages = new Msingi_Model_Constants_Languages();

		// check is it language at all
		if (!$languages->isLanguage($language))
		{
			// not a language
			$redirect = true;
		}
		else if (!in_array($language, $available_languages))
		{
			// language detected ok, but not available
			// remove it from the path
			array_shift($path);
			$redirect = true;
		}
		else
		{
			// language detected ok and is available
			$redirect = false;
		}

		// need to redirect to correct language version
		if ($redirect)
		{
			// try to get language from previous visits
			$language = $this->getCookieLanguage();

			// try to select language from accepted ones
			if ($language == '' || !in_array($language, $available_languages))
				$language = $this->getAcceptedLanguage($available_languages);

			// language is unavailable, select default one
			if ($language == '')
				$language = $default_language;

			// construct uri back
			$site = Zend_Registry::get('Sections');
			$section = $site->getCurrentSection();

			$uri = $section->root() . '/' . $language . '/' . implode('/', $path);
			if (isset($parsed_uri['query']) && $parsed_uri['query'] != '')
			{
				$uri .= '?' . $parsed_uri['query'];
			}

			// redirect to correct page
			$this->_setRequestParams($request, array(
				'module' => 'default',
				'controller' => 'redirect',
				'action' => 'index',
				'uri' => $uri,
			));

			return $request;
		}

		// get language from path
		$language = array_shift($path);

		// save language to cookie
		setcookie('language', $language, time() + 60 * 60 * 24 * 3650, '/');

		// construct uri without language substring
		$uri = '/' . implode('/', $path);
		if (isset($parsed_uri['query']) && $parsed_uri['query'] != '')
		{
			$uri .= '?' . $parsed_uri['query'];
		}

		//
		$this->initLocale($languages->getLocale($language));

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

		// parse with default router
		$request->setRequestUri($uri);
		$request->setPathInfo($uri);

		return parent::route($request);
	}

	/**
	 *
	 * @todo make relative paths from root
	 * @param type $userParams
	 * @param type $name
	 * @param type $reset
	 * @param type $encode
	 * @return string
	 * @throws Zend_Controller_Router_Exception
	 */
	public function assemble($userParams, $name = null, $reset = false, $encode = true)
	{
		$root = '';

		$sections = Zend_Registry::get('Sections');
		if (isset($userParams['section']) && $userParams['section'] != '')
		{
			$section = $sections->getSection($userParams['section']);
			if ($section == null)
			{
				throw new Zend_Exception(sprintf('Undefined section "%s"', $userParams['section']));
			}
		}
		else
		{
			$section = $sections->getCurrentSection();
		}

		unset($userParams['section']);

		$root = $section->root();

		if (isset($userParams['language']))
		{
			$language = $userParams['language'];
			unset($userParams['language']);
		}
		else
		{
			$locale = Zend_Registry::get('Zend_Locale');
			$language = $locale->getLanguage();
		}

		// construct url
		$path = rtrim($root, '/') . '/' . $language . parent::assemble($userParams, $name, $reset, $encode);

		return $path;
	}

	/**
	 *
	 * @return string
	 */
	protected function getCookieLanguage()
	{
		if (isset($_COOKIE['language']))
		{
			return trim($_COOKIE['language']);
		}
		return '';
	}

	/**
	 *
	 * @param type $available_languages
	 * @return type
	 */
	protected function getAcceptedLanguage($available_languages)
	{
		$language = '';
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			// break up accepted languages into pieces (languages and q factors)
			preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);

			if (count($lang_parse[1]))
			{
				// create a list like "en" => 0.8
				$langs = array_combine($lang_parse[1], $lang_parse[4]);

				// set default to 1 for any without q factor
				foreach ($langs as $lang => $val)
				{
					if ($val === '')
						$langs[$lang] = 1;
				}

				// sort list based on value
				arsort($langs, SORT_NUMERIC);
			}

			// check there is available language
			foreach (array_keys($langs) as $l)
			{
				$l = substr($l, 0, 2);
				if (in_array($l, $available_languages))
				{
					$language = $l;
					break;
				}
			}
		}

		return $language;
	}

}