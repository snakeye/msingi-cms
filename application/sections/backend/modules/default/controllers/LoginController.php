<?php

class LoginController extends Msingi_Controller
{

	/**
	 *
	 */
	public function preDispatch()
	{
		parent::preDispatch();

		$auth = Zend_Auth::getInstance();

		$rq = $this->getRequest();

		if ($rq->getActionName() == 'logout')
		{
			if ($auth->hasIdentity())
			{
				$auth->clearIdentity();
			}
			$this->_helper->redirector('index', 'index', 'default');
		}

		if ($auth->hasIdentity())
		{
			// unauthorized
			$this->_helper->redirector('index', 'index', 'default');
		}

		$this->view->layout()->setLayout('login');
	}

	/**
	 *
	 */
	public function indexAction()
	{
		$rq = $this->getRequest();

		$form = new Form_Login();

		if ($rq->isPost())
		{
			if ($form->isValid($rq->getPost()))
			{
				$values = $form->getValues();

				// Get our authentication adapter and check credentials
				$adapter = $this->getAuthAdapter($values);
				$zend_auth = Zend_Auth::getInstance();
				$result = $zend_auth->authenticate($adapter);

				if (!$result->isValid())
				{
					$form->setDescription($this->_('Invalid credentials provided'));
					$this->view->form = $form;
					return $this->render('index'); // re-render the login form
				}

				// store the identity as an object where only the username and
				// role have been returned
				$storage = $zend_auth->getStorage();
				$storage->write($adapter->getResultRowObject(array('username', 'role', 'name', 'id')));

				// We're authenticated! Redirect to the home page
				if ($values['back'] != '')
				{
					return $this->_redirect($values['back']);
				}

				$this->_helper->redirector('index');
			}
		}
		else
		{
			$form->getElement('back')->setValue($rq->get('back'));
		}

		$this->view->form = $form;
	}

	/**
	 *
	 * @param array $params
	 * @return \Zend_Auth_Adapter_DbTable
	 */
	public function getAuthAdapter(array $params)
	{
		$table = Backend_Auth::getInstance();

		$authAdapter = new Zend_Auth_Adapter_DbTable($table->getAdapter());
		$authAdapter->setTableName('auth_backend');

		$authAdapter->setIdentityColumn('username');
		$authAdapter->setIdentity($params['username']);

		$authAdapter->setCredentialColumn('password');
		$authAdapter->setCredential(md5(Backend_Auth::getSalt() . $params['password']));

		return $authAdapter;
	}

}