<?php

/**
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class View_Helper_FetchMenu extends Zend_View_Helper_Abstract
{

	/**
	 * Fetch menu
	 *
	 * @param string $name
	 * @return \Zend_Navigation
	 */
	public function fetchMenu($name)
	{
		$menu_table = Cms_MenuItems::getInstance();

		$menuConfig = $menu_table->fetchByName($name, $this->view->language());

		$menuContainer = new Zend_Navigation($menuConfig);

		return $menuContainer;
	}

}
