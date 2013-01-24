<?php

/**
 *
 */
class Msingi_View_Helper_Assets extends Zend_View_Helper_Abstract
{

	/**
	 * Assets URL for current section
	 *
	 * @return string URL
	 */
	public function assets($subdir = '')
	{
		if (!Zend_Registry::isRegistered('Sections'))
		{
			throw new Zend_Exception('Resource Sections not found');
		}

		//
		$site = Zend_Registry::get('Sections');

		// get current site section
		$currentSection = $site->getCurrentSection();

		// get assets url for this section
		$assets_url = $currentSection->assets();

		//
		$settings = Msingi_Model_Settings::getInstance();
		$theme = $settings->get('section:' . $currentSection->name() . ':appearance:theme', 'default');

		//
		$assets_url .= '/' . $theme;

		//
		if ($subdir != '')
			$assets_url .= '/' . $subdir;

		return $assets_url;
	}

}