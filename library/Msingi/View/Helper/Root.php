<?php

/**
 *
 */
class Msingi_View_Helper_Root extends Zend_View_Helper_Abstract
{

	/**
	 * Return theme for current section
	 *
	 * @return \Msingi_Themes_Theme
	 */
	public function root()
	{
		if (!Zend_Registry::isRegistered('Sections'))
		{
			throw new Zend_Exception('Resource Sections not found');
		}

		$site = Zend_Registry::get('Sections');

		$section = $site->getCurrentSection();

		return $section->root();
	}

}