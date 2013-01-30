<?php

class Users_IndexController extends Msingi_Controller_Backend_ListingAbstract
{

	/**
	 *
	 */
	public function preDispatch()
	{
		parent::preDispatch();
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
		return new Cms_Users();
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