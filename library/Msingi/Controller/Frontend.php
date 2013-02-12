<?php

/**
 * Base class for frontend controllers
 *
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Controller_Frontend extends Msingi_Controller
{

	/**
	 *
	 */
	public function preDispatch()
	{
		parent::preDispatch();

		$rq = $this->getRequest();

		// get current page
		$page = $rq->get('__page');
		if ($page == null)
		{
			$pages = new Msingi_Model_Pages_PagesTable();
			$page = $pages->fetchByRequest($rq, true);
		}

		// set SEO properties
		if ($page != null)
		{
			$locale = Zend_Registry::get('Zend_Locale');

			$texts = $page->getTexts($locale->getLanguage(), true);

			$this->view->title = $texts->title;
			$this->view->meta_keywords = $texts->meta_keywords;
			$this->view->meta_description = $texts->meta_description;

			// page content
			$this->view->page_content = $page->content($locale->getLanguage());
		}
	}

}