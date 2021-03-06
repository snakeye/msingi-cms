<?php

/**
 * Widgets - blocks of text used across different pages
 *
 * @package MsingiCms
 */
class Cms_Widgets extends Msingi_Db_Table_Multilanguage
{

	protected $_name = 'cms_widgets';
	protected $_rowClass = 'Cms_Widget';

	//protected $_dependentTables = array('Widgets_Texts');

	/**
	 * Fetch widget
	 * 
	 * @param string $position
	 * @param boolean $create
	 * @return Cms_Widget
	 */
	public function fetchWidget($position, $create = true)
	{
		$position = $this->formatPosition($position);

		$cache = Zend_Registry::get('Zend_Cache');
		$cache_id = $this->_getCacheId($position);

		if (($widget = $cache->load($cache_id)) === false)
		{
			$select = $this->select()->where('position = ?', $position);

			$widget = $this->fetchRow($select);

			if ($widget == null && $create)
			{
				$widget = $this->createRow();
				$widget->position = $position;
				$widget->save();
			}

			if ($widget != null)
				$cache->save($widget, $cache_id);
		}

		return $widget;
	}

	/**
	 *
	 * @param type $name
	 * @param type $language
	 * @return string
	 */
	protected function _getCacheId($position)
	{
		return $this->_name . '_' . $position;
	}

	/**
	 *
	 * @param type $position
	 */
	protected function formatPosition($position)
	{
		$position = preg_replace('#[^a-z0-9_]#i', '_', $position);
		$position = preg_replace('#_+#', '_', $position);

		return $position;
	}

}