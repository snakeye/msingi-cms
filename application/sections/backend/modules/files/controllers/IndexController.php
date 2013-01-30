<?php

class Files_IndexController extends Msingi_Controller_Backend_ListingAbstract
{

	protected function getEditForm()
	{

	}

	protected function getFilter()
	{

	}

	protected function getPaginatorQuery($request, $filter)
	{
		$table = $this->getTable();

		return $table->select();
	}

	protected function getTable()
	{
		return Cms_Files::getInstance();
	}

}