<?php

class IndexController extends Msingi_Controller_Frontend
{

	public function indexAction()
	{
		$this->view->layout()->setLayout('frontpage');
	}

}