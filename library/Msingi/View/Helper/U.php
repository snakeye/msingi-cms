<?php

class Msingi_View_Helper_U extends Zend_View_Helper_Abstract
{

	protected $parts = array(
		'action' => 'index',
		'controller' => 'index',
		'module' => 'default',
		'section' => 'current'
	);

	/**
	 *
	 * @param type $url
	 * @param type $params
	 * @return type
	 */
	public function u($url, $params = array())
	{
		$urlOptions = array();

		// language
		$sections = Zend_Registry::get('Sections');
		$currentSection = $sections->getCurrentSection();

		$settings = Msingi_Model_Settings::getInstance();
		$section_type = $settings->get('section:' . $currentSection->name() . ':languages:type', 'single');

		if ($section_type == 'multi')
		{
			if (!isset($params['language']))
			{
				$locale = Zend_Registry::get('Zend_Locale');
				$urlOptions['language'] = $locale->getLanguage();
			}
		}

		foreach ($params as $key => $value)
		{
			$urlOptions[$key] = $value;
		}

		$urlOptions = array_filter($urlOptions);

		//
		if ($url == '' || $url == '#current')
		{
			$request = Zend_Controller_Front::getInstance()->getRequest();
			if ($request->getModuleName() == 'default' && $request->getControllerName() == 'page')
			{
				$page = $request->getParam('__page');

				$path = array();
				do
				{
					$path[] = $page->pathLast();
					$page = $page->parent();
				}
				while ($page->parent_id != null);

				$path[] = $urlOptions['language'];

				return '/' . implode('/', array_reverse($path));
			}
			else
			{
				$router = Zend_Controller_Front::getInstance()->getRouter();
				return $router->assemble($urlOptions, null, false);
			}
		}
		else
		{
			$url = explode(':', $url);

			$urlOptions['module'] = isset($url[0]) ? $url[0] : 'default';
			$urlOptions['controller'] = isset($url[1]) ? $url[1] : 'index';
			$urlOptions['action'] = isset($url[2]) ? $url[2] : 'index';

			$router = Zend_Controller_Front::getInstance()->getRouter();
			return $router->assemble($urlOptions, 'default', true);
		}
	}

}