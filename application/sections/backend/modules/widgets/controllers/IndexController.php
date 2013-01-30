<?php

class Widgets_IndexController extends Msingi_Controller_Backend_ListingAbstract
{

	/**
	 *
	 */
	protected function getEditForm()
	{
		return new Form_Widget();
	}

	/**
	 *
	 * @param type $request
	 * @return type
	 */
	protected function getPaginatorQuery($request, $filter)
	{
		$table = $this->getTable();

		return $table->select()->order('position ASC');
	}

	/**
	 *
	 * @return \MailTemplatesTable
	 */
	protected function getTable()
	{
		return new Cms_Widgets();
	}

	/**
	 *
	 */
	protected function getFilter()
	{

	}

}