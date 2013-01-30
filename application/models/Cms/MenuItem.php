<?php

/**
 * @package MsingiCms
 */
class Cms_MenuItem extends Msingi_Db_Table_Row_Multilanguage
{

	/**
	 *
	 */
	public function delete()
	{
		$select = Cms_MenuItems::getInstance()->select()->where('parent_id = ?', $this->id);
		$subitems = Cms_MenuItems::getInstance()->fetchAll($select);
		foreach ($subitems as $subitem)
		{
			$subitem->delete();
		}

		parent::delete();
	}

}