<?php

/**
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Cms_Menus extends Msingi_Db_Table_Multilanguage
{

	protected $_name = 'cms_menus';

	/**
	 *
	 * @return array
	 */
	public function fetchArray()
	{
		$select = $this->select()->from($this, array('name', 'title'))->order('title');

		return $this->getAdapter()->fetchPairs($select);
	}

}