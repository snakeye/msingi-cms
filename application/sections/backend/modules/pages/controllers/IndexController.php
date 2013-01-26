<?php

class Pages_IndexController extends Msingi_Controller_Backend
{

	/**
	 *
	 */
	public function indexAction()
	{
		$rq = $this->getRequest();

		$pages = new Msingi_Model_Pages_PagesTable();

		// get root page
		$root = $pages->fetchRoot();

		// get current page
		$page = $pages->fetchById($rq->get('id'));
		if ($page == null)
			$page = $root;

		//
		$this->view->page = $page;

		// get form
		$form = new Form_Page();

		$form->createControls($page);

		$form->fillValues($page);

		$this->view->form = $form;

		// sidebar
		//$this->view->layout()->sidebar = $this->view->partial('pages/_sidebar.phtml', array('root' => $root, 'current_page' => $page));
	}

	/**
	 *
	 * @return type
	 */
	public function saveAction()
	{
		$rq = $this->getRequest();

		if (!$rq->isPost())
			return $this->_helper->redirector('index');

		$post = $rq->getPost();

		$pages = new Msingi_Model_Pages_PagesTable();

		// get current page
		$page = $pages->fetchById($post['id'], false);
		if ($page == null)
			return $this->_helper->redirector('index');

		$form = new Form_Page();

		$form->createControls($page);

		if (!$form->isValid($post))
			return $this->render('index');

		$values = $form->getValues();

		if ($page->type == 'path')
		{
			$page->path = $values['path'];
			$page->template_id = $values['template_id'];
			$page->save();
		}

		$languages = Msingi_Application_Settings::getInstance()->getArray('section:frontend:languages:enabled');

		$template = $page->template();

		foreach ($languages as $lang)
		{
			$page_texts = $page->getTexts($lang, true, false);

			$page_texts->title = $values['title_' . $lang];
			$page_texts->meta_keywords = $values['meta_keywords_' . $lang];
			$page_texts->meta_description = $values['meta_description_' . $lang];

			$page_texts->save();

			if ($template != null)
			{
				foreach ($template->sections() as $section)
				{
					$page_section = $page->section($section, true);

					$page_section_texts = $page_section->getTexts($lang, true, false);

					$page_section_texts->content = $values['section_' . $this->filter_section_name($section) . '_' . $lang];

					$page_section_texts->save();
				}
			}
		}

		return $this->_helper->redirector('index', 'pages', 'default', array('id' => $page->id));
	}

	/**
	 *
	 * @return type
	 */
	public function addAction()
	{
		$rq = $this->getRequest();

		$route = trim($rq->get('page_name'));
		$route = preg_replace('/[^a-z0-9\-]+/i', '', $route);

		if ($route != '')
		{
			$pages = new Msingi_Model_Pages_PagesTable();

			$page = $pages->createRow(array(
				'parent_id' => 1,
				'can_delete' => 1,
				'type' => 'path',
				'path' => $route,
				));

			$page->save();

			return $this->_helper->redirector('index', 'pages', 'default', array('id' => $page->id));
		}

		return $this->_helper->redirector('index', 'pages', 'default');
	}

	/**
	 *
	 */
	public function deleteAction()
	{
		$rq = $this->getRequest();

		$pages = new Msingi_Model_Pages_PagesTable();

		// get root page
		$root = $pages->fetchRoot();

		// get current page
		$page = $pages->fetchById($rq->get('id'));
		if ($page != null)
		{
			$page->delete();
		}

		return $this->_helper->redirector('index', 'pages', 'default');
	}

	/**
	 *
	 */
	public function setparentAction()
	{
		// ajax
		$this->ajaxResponse();

		//
		$rq = $this->getRequest();

		$pages = new Msingi_Model_Pages_PagesTable();

		$parent = intval(str_replace('page-', '', $rq->get('parent')));
		$child = intval(str_replace('page-', '', $rq->get('child')));

		$page = $pages->fetchById($child);
		if ($page != null)
		{
			$page->parent_id = $parent;

			$page->save();
		}

		$this->_helper->json(array('success' => true));
	}

	/**
	 *
	 * @param type $section
	 * @return type
	 */
	protected function filter_section_name($section)
	{
		$section = preg_replace('/[^a-zA-Z0-9-_]/', '', $section);
		$section = preg_replace('/[-]+/', '_', $section);

		return $section;
	}

}