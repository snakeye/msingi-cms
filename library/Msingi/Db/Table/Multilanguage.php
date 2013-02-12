<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Db_Table_Multilanguage extends Msingi_Db_Table
{

	/**
	 *
	 * @return string
	 */
	public function getTextsTable()
	{
		//
		$table_name = $this->_name . '_texts';

		// create generic table
		$table = new Msingi_Db_Table_MultilanguageTexts(array('name' => $table_name));

		return $table;
	}

}