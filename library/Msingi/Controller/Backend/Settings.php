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
	 * @param type $section
	 * @return \Form_Settings
	 */
	protected function getForm($section)
	{
		if (isset($section['form']) && $section['form'] != '')
		{
			$form_class = $section['form'];
			$form = new $form_class();
		}
		else
		{
			$form = new Form_Settings();
		}

		$form->createElements(isset($section['settings']) ? $section['settings'] : null);

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

			$section_id = intval($post['section']);
			if (!isset($this->_settings[$section_id]))
				return $this->_helper->redirector('index');

			$section = $this->_settings[$section_id];

			$form = $this->getForm($section);

			if ($form->isValid($post))
			{
				$form->updateSettings($section['settings'], $form->getValues());

				return $this->_helper->redirector('index', 'index', 'settings', array('section' => $section_id));
			}
		}
		else
		{
			$section_id = intval($rq->get('section'));
			if (!isset($this->_settings[$section_id]))
				return $this->_helper->redirector('index');
			$section = $this->_settings[$section_id];

			$form = $this->getForm($section);

			$form->getElement('section')->setValue($section_id);

			$form->fill(isset($section['settings']) ? $section['settings'] : null);
		}

		$this->view->form = $form;
		$this->view->section_label = $section['label'];

		if (isset($section['view']) && $section['view'] != '')
			return $this->render($section['view']);
	}

}
