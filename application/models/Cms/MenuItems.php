<?php

class Cms_MenuItems extends Msingi_Db_Table_Multilanguage
{

	protected $_name = 'cms_menu';
	protected $_rowClass = 'Cms_MenuItem';
	protected $_dependentTables = array('Cms_MenuItemTexts');

	/**
	 *
	 * @param type $name
	 * @return type
	 */
	public function fetchByName($name, $language)
	{
		$cache = Zend_Registry::get('Zend_Cache');
		$cache_id = $this->_getCacheId(array($name, $language));

		if (($menu = $cache->load($cache_id)) === false)
		{
			$menu = $this->fetchArray($name, null, $language);

			$cache->save($menu, $cache_id);
		}

		return $menu;
	}

	/**
	 *
	 * @param type $name
	 * @param type $parent_id
	 * @return array
	 */
	protected function fetchArray($name, $parent_id, $language)
	{
		$select = $this->select()->where('name = ?', $name)->order('order');
		if ($parent_id == null)
		{
			$select->where('parent_id IS NULL');
		}
		else
		{
			$select->where('parent_id = ?', $parent_id);
		}

		$list = $this->fetchAll($select);

		$ret = array();

		foreach ($list as $item)
		{
			$item_array = array();

			$uri = explode(':', $item->uri);
			if (count($uri) == 3)
			{
				$item_array['route'] = 'default';
				$item_array['module'] = $uri[0];
				$item_array['controller'] = $uri[1];
				$item_array['action'] = $uri[2];
			}
			else
			{
				$item_array['uri'] = $item->uri;
			}

			$texts = $item->getTexts($language, true);
			if ($texts->label != '')
				$item_array['label'] = $texts->label;

			$subitems = $this->fetchArray($name, $item->id, $language);
			if (count($subitems) > 0)
			{
				$item_array['pages'] = $subitems;
			}

			$ret[] = $item_array;
		}

		return $ret;
	}

	/**
	 *
	 * @param type $name
	 * @param type $parent_id
	 * @return type
	 */
	public function fetchTree($name, $parent_id = null)
	{
		$select = $this->select()->where('name = ?', $name)->order('order');
		if ($parent_id == null)
		{
			$select->where('parent_id IS NULL');
		}
		else
		{
			$select->where('parent_id = ?', $parent_id);
		}

		$list = $this->fetchAll($select);

		$ret = array();
		foreach ($list as $item)
		{
			$item_array = array(
				'item' => $item
			);

			$subitems = $this->fetchTree($name, $item->id);
			if (count($subitems) > 0)
			{
				$item_array['subitems'] = $subitems;
			}

			$ret[] = $item_array;
		}

		return $ret;
	}

	/**
	 *
	 * @param type $sort
	 */
	public function sortMenu($name, $sort)
	{
		//$select = $this->select()->from($this)->where('name = ?', $name);
		//$items = $this->fetchAll($select);

		$order = 0;
		foreach ($sort as $item_id => $parent_id)
		{
			if ($parent_id == 'null')
				$parent_id = null;

			$item = $this->fetchById($item_id);
			if ($item != null)
			{
				$item->parent_id = $parent_id;
				$item->order = $order++;
				$item->save();
			}
		}
	}

}