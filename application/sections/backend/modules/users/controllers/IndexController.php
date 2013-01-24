<?php

class Users_IndexController extends Msingi_Controller_Backend_ListingAbstract
{

	/**
	 *
	 */
	public function preDispatch()
	{
		parent::preDispatch();

		$this->view->layout()->sidebar = $this->view->partial('_sidebar.phtml');
	}

	/**
	 *
	 * @return \Form_Admin
	 */
	protected function getEditForm()
	{
		$form = new Form_User();
		$form->getElement('role')->addMultiOptions(array(
			'admin' => $this->_('Administrator'),
			'moderator' => $this->_('Moderator'),
		));

		return $form;
	}

	/**
	 *
	 * @return \Auth_Backend
	 */
	protected function getTable()
	{
		return new Backend_Auth();
	}

	/**
	 *
	 * @param type $request
	 * @return type
	 */
	protected function getPaginatorQuery($request, $filter)
	{
		$table = $this->getTable();

		return $table->select();
	}

	/**
	 *
	 */
	protected function getFilter()
	{

	}

}