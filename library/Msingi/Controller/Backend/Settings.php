<?php

class Msingi_Controller_Backend_Settings extends Msingi_Controller_Backend
{

	protected $_settings;

	/**
	 *
	 */
	public function preDispatch()
	{
		parent::preDispatch();

		$this->_init();
	}

	/**
	 *
	 * @param type $group
	 * @return \Form_Settings
	 */
	protected function getForm($group)
	{
		if (isset($group['form']) && $group['form'] != '')
		{
			$form_class = $group['form'];
			$form = new $form_class();
		}
		else
		{
			$form = new Form_Settings();
		}

		$form->createElements(isset($group['settings']) ? $group['settings'] : null);

		return $form;
	}

	/**
	 *
	 */
	public function indexAction()
	{
		$rq = $this->getRequest();

		if ($rq->isPost())
		{
			$post = $rq->getPost();

			$group_id = intval($post['group']);
			if (!isset($this->_settings[$group_id]))
				return $this->_helper->redirector('index');

			$group = $this->_settings[$group_id];

			$form = $this->getForm($group);

			if ($form->isValid($post))
			{
				$form->updateSettings($group['settings'], $form->getValues());

				return $this->_helper->redirector('index', 'index', 'settings', array('group' => $group_id));
			}
		}
		else
		{
			$group_id = intval($rq->get('group'));
			if (!isset($this->_settings[$group_id]))
				return $this->_helper->redirector('index');
			$group = $this->_settings[$group_id];

			$form = $this->getForm($group);

			$form->getElement('group')->setValue($group_id);

			$form->fill(isset($group['settings']) ? $group['settings'] : null);
		}

		$this->view->form = $form;
		$this->view->group_label = $group['label'];

		if (isset($group['view']) && $group['view'] != '')
			return $this->render($group['view']);
	}

}
