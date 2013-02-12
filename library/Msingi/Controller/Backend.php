<?php

/**
 * Base class for backend controllers
 *
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Controller_Backend extends Msingi_Controller
{

	/**
	 *
	 */
	public function preDispatch()
	{
		$auth = Zend_Auth::getInstance();

		if (!$auth->hasIdentity())
		{
			// unauthorized
			$this->_redirect($this->view->root() . '/login?back=' . urlencode($_SERVER['REQUEST_URI']));
		}

		// get resource
		$rq = $this->getRequest();
		$resource = $rq->module . '.' . $rq->controller;

		// get acl
		$acl = Zend_Registry::get('acl');
		if ($acl != null && !$acl->isAllowed($auth->getIdentity()->role, $resource))
		{
			// access denied
			$this->_redirect('/');
		}

		// update navigation
		$this->view->navigation()->setAcl($acl)->setRole($auth->getIdentity()->role);
	}

}