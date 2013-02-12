<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Db_Table_Row_MultilanguageTexts extends Msingi_Db_Table_Row
{

	/**
	 *
	 */
	public function save()
	{
		$table = $this->getTable();
		if ($table == null)
		{
			// detached object
			$table = new $this->_tableClass();
		}

		$table->clearCache($this->parent_id, $this->language);

		parent::save();
	}

}