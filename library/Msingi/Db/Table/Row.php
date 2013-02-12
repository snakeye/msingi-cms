<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Db_Table_Row extends Zend_Db_Table_Row
{

	/**
	 * Get list of values from associated dictionary
	 *
	 * @param string $name
	 * @return
	 */
	public function getDictionary($name)
	{

	}

	/**
	 *
	 * @param type $columnName
	 * @param type $value
	 * @return boolean
	 */
	public function hasSetValue($columnName, $value)
	{
		$setValues = explode(',', $this->_data[$columnName]);

		return in_array($value, $setValues);
	}

	/**
	 *
	 * @param type $data
	 * @return string
	 */
	public function valuesOfSet($data)
	{
		if (is_array($data))
		{
			return implode(',', $data);
		}

		return '';
	}

}