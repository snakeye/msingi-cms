<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_View_Helper_Section extends Zend_View_Helper_Abstract
{

	/**
	 * Return theme for current section
	 *
	 * @return \Msingi_Themes_Theme
	 */
	public function section($name)
	{
		if (!Zend_Registry::isRegistered('Sections'))
		{
			throw new Zend_Exception('Resource Sections not found');
		}

		$site = Zend_Registry::get('Sections');

		$section = $site->getSection($name);
		if ($section == null)
		{
			throw new Zend_Exception(sprintf('Section %s not found', $name));
		}

		return $section->root();
	}

}