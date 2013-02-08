<?php

class Files_IndexController extends Msingi_Controller_Backend_ListingAbstract
{

	protected function getEditForm()
	{
		return new Form_File();
	}

	protected function getFilter()
	{

	}

	protected function getPaginatorQuery($request, $filter)
	{
		$table = $this->getTable();

		return $table->select()->order('dt DESC');
	}

	protected function getTable()
	{
		return Cms_Files::getInstance();
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

		if ($form->file->isReceived())
		{
			$file = $form->file->getFileName();
			$basename = basename($file);
			$mime = Msingi_Util_Mime::content_type($file);

			$row->name = $basename;
			$row->mime = $mime;
			$row->setFile($file);
		}

		$row->dt = date('Y-m-d H:i:s');
		$row->save();
	}

}