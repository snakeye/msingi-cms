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
		$menu_table = new Cms_MenuTable();
		$select = $menu_table->select()->where('parent_id = ?', $this->id);
		$subitems = $menu_table->fetchAll($select);
		foreach ($subitems as $subitem)
		{
			$subitem->delete();
		}

		parent::delete();
	}

}