<?php

class Msingi_Controller_Error extends Msingi_Controller
{

	protected $_layout = null;

	/**
	 *
	 * @return type
	 */
	public function errorAction()
	{
		// set layout
		if ($this->_layout != '')
		{
			$this->view->layout()->setLayout($this->_layout);
		}

		// check
		$errors = $this->_getParam('error_handler');
		if (!$errors)
		{
			$this->view->message = $this->_('You have reached the error page');
			return;
		}

		//
		switch ($errors->type)
		{
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				// 404 error -- route, controller or action not found
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->code = 404;
				$this->view->message = $this->_('Page not found');
				break;

			default:
				// application error, return 500 code
				$this->getResponse()->setHttpResponseCode(500);
				$this->view->code = 500;
				$this->view->message = $this->_('Application error');

				// Log application error, if logger available
				if ($log = $this->getLog())
				{
					$log->crit($this->view->message, $errors->exception);
				}

				break;
		}

		$this->view->title = $this->view->message;

		// conditionally display exceptions
		if (APPLICATION_ENV == 'development')
		{
			$this->view->exception = $errors->exception;
		}

		$this->view->request = $errors->request;
	}

}