<?php

/**
 * Index controller
 *
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class IndexController extends Msingi_Controller_Frontend
{

	/**
	 * Index action
	 */
	public function indexAction()
	{
		$this->view->layout()->setLayout('frontpage');
	}

}