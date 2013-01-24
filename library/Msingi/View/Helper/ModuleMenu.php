<?php

/**
 *
 */
class Msingi_View_Helper_ModuleMenu extends Zend_View_Helper_Abstract
{

	protected $_translator;

	/**
	 *
	 * @param type $menuName
	 */
	public function moduleMenu($menuName)
	{
		$request = Zend_Controller_Front::getInstance()->getRequest();

		$menu = APPLICATION_PATH . '/sections/' . $request->getSectionName() . '/resources/navigation/' . $menuName . '.php';

		if (is_file($menu))
		{
			ob_start();
			$menuConfig = include($menu);
			ob_end_clean();

			//
			$menuContainer = new Zend_Navigation($menuConfig);

			//
			return $this->view->navigation($menuContainer);
		}

		return null;
	}

	/**
	 *
	 * @param string $string
	 */
	public function _($string)
	{
		$translator = $this->getTranslator();
		return $translator->_($string);
	}

	/**
	 *
	 */
	public function getTranslator()
	{
		if ($this->_translator == null)
		{
			$this->_translator = $this->view->getTranslator();
		}

		return $this->_translator;
	}

	/**
	 *
	 */
	public function language()
	{
		$locale = Zend_Registry::get('Zend_Locale');

		return $locale->getLanguage();
	}

}