<?php

class Images_IndexController extends Msingi_Controller_Backend_ListingAbstract
{

	/**
	 *
	 */
	protected function getEditForm()
	{
		return new Form_Image();
	}

	/**
	 *
	 * @param type $request
	 * @return type
	 */
	protected function getPaginatorQuery($request, $filter)
	{
		$table = $this->getTable();

		return $table->select()->order('dt DESC');
	}

	/**
	 *
	 * @return \MailTemplatesTable
	 */
	protected function getTable()
	{
		return Cms_Images::getInstance();
	}

	/**
	 *
	 */
	protected function getFilter()
	{

	}

	/**
	 *
	 * @param type $row
	 * @param type $values
	 * @param type $form
	 */
	protected function updateRow($row, $values, $form)
	{
		parent::updateRow($row, $values, $form);

		if ($form->image->isReceived())
		{
			$row->setImage($form->image->getFileName());
			$row->name = basename($form->image->getFileName());
		}

		$row->dt = date('Y-m-d H:i:s');
		$row->save();
	}

}