<?php

/**
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class PageController extends Msingi_Controller_Frontend
{

	/**
	 * Index action
	 */
	public function indexAction()
	{
		$rq = $this->getRequest();

		// get page object
		$page = $rq->get('__page');
		if ($page == null)
			return $this->_helper->redirector('index', 'index', 'default');

		$this->view->page = $page;

		$template = $page->template();
		if ($template != null)
		{
			return $this->render($template->name);
		}
	}

}