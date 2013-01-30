<?php

class Menu_IndexController extends Msingi_Controller_Backend
{

	/**
	 *
	 * @return type
	 */
	protected function getMenus()
	{
		$menus = new Cms_Menus();

		return $menus->fetchArray();
	}

	/**
	 *
	 */
	public function indexAction()
	{
		$rq = $this->getRequest();

		$menus = $this->getMenus();
		$menu = trim($rq->get('name'));
		if ($menu == '' || !in_array($menu, array_keys($menus)))
			$menu = current(array_keys($menus));

		$pages = new Msingi_Model_Pages_PagesTable();

		$this->view->menu = $menu;

		// sidebar
		$this->view->layout()->sidebar = $this->view->partial('index/_sidebar.phtml', array(
			'menus' => $this->getMenus(),
			'current_menu' => $menu,
			'root' => $pages->fetchRoot()
				)
		);
	}

	/**
	 *
	 */
	public function gettreeAction()
	{
		$this->ajaxResponse();

		$rq = $this->getRequest();

		$menus_table = new Cms_MenuItems();

		$this->view->language = $rq->get('language');
		$this->view->menu = $menus_table->fetchTree($rq->get('name'));

		return $this->render('get-tree');
	}

	/**
	 *
	 */
	public function sorttreeAction()
	{
		$this->ajaxResponse();

		$rq = $this->getRequest();

		$menus_table = new Cms_MenuItems();

		$menus_table->sortMenu($rq->get('menu'), $rq->get('menu-item'));

		return $this->_helper->json(array());
	}

	/**
	 *
	 * @return type
	 */
	public function deleteitemAction()
	{
		$this->ajaxResponse();

		$rq = $this->getRequest();

		$menus_table = new Cms_MenuItems();

		$item = $menus_table->fetchById($rq->get('id'));
		if ($item != null)
		{
			$item->delete();
		}

		return $this->_helper->json(array());
	}

	/**
	 *
	 * @return type
	 */
	public function addpageAction()
	{
		$this->ajaxResponse();

		$rq = $this->getRequest();

		$pages = new Msingi_Model_Pages_PagesTable();

		$page = $pages->fetchById($rq->get('id'));
		if ($page != null)
		{
			$menus_table = new Cms_MenuItems();
			$item = $menus_table->createRow(array(
				'parent_id' => null,
				'name' => $rq->get('menu'),
				'order' => 0,
				'uri' => $page->getMenuUrl(),
					));

			$item->save();
		}

		return $this->_helper->json(array());
	}

	/**
	 *
	 */
	public function labelformAction()
	{
		$this->ajaxResponse();

		$rq = $this->getRequest();

		$menus_table = new Cms_MenuItems();

		$this->view->item = $menus_table->fetchById($rq->get('id'));
		$this->view->language = $rq->get('language');

		return $this->render('label-form');
	}

	/**
	 *
	 */
	public function savelabelsAction()
	{
		$this->ajaxResponse();

		$rq = $this->getRequest();

		$values = $rq->getPost();

		$menus_table = new Cms_MenuItems();

		$item = $menus_table->fetchById($values['id']);
		if ($item != null)
		{
			$texts = $item->getTexts($values['language'], true, false);

			$texts->label = $values['label'];

			$texts->save();
		}

		return $this->_helper->json(array());
	}

}