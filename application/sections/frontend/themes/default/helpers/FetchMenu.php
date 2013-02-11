<?php

class View_Helper_FetchMenu extends Zend_View_Helper_Abstract
{

	public function fetchMenu($name)
	{
		$menu_table = Cms_MenuItems::getInstance();

		$menuConfig = $menu_table->fetchByName($name, $this->view->language());

		$menuContainer = new Zend_Navigation($menuConfig);

		return $menuContainer;
	}

}
