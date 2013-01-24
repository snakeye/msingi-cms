<?php

class Msingi_Controller_Plugin_ViewScripts extends Zend_Controller_Plugin_Abstract
{

	/**
	 *
	 * @param Zend_Controller_Request_Abstract $request
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$view = Zend_Controller_Action_HelperBroker::getExistingHelper('ViewRenderer')->view;

		// site
		$site = Zend_Registry::get('Sections');

		// current section
		$current_section = $site->getCurrentSection();

		$theme = Msingi_Model_Settings::getInstance()->get('section:' . $current_section->name() . ':appearance:theme', 'default');

		// compose path
		$scriptPath = sprintf('%s/sections/%s/themes/%s/modules/%s', APPLICATION_PATH, $current_section->name(), $theme, $request->getModuleName());
		if (is_dir($scriptPath))
		{
			$view->setScriptPath($scriptPath);
		}

		$helperPath = sprintf('%s/sections/%s/themes/%s/helpers', APPLICATION_PATH, $current_section->name(), $theme);
		if (is_dir($helperPath))
		{
			$view->addHelperPath($helperPath, 'View_Helper_');
		}
	}

}