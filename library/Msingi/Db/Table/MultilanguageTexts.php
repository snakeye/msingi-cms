<?php

class Msingi_Db_Table_MultilanguageTexts extends Msingi_Db_Table
{

	protected $_rowClass = 'Msingi_Db_Table_Row_MultilanguageTexts';

	/**
	 *
	 * @param type $row_id
	 * @param type $language
	 * @param type $create
	 * @return type
	 */
	public function fetchTexts($row_id, $language, $create = false, $cache = true)
	{
		if ($cache)
		{
			$cache = Zend_Registry::get('Zend_Cache');
			$cache_id = $this->_getCacheId(array($row_id, $language));

			if (($row = $cache->load($cache_id)) === false)
			{
				$row = $this->_fetchRow($row_id, $language, $create);

				if ($row != null)
					$cache->save($row, $cache_id);
			}
		}
		else
		{
			$row = $this->_fetchRow($row_id, $language, $create);
		}

		// return the data
		return $row;
	}

	/**
	 *
	 * @param type $row_id
	 * @param type $language
	 */
	public function clearCache($row_id, $language)
	{
		$cache = Zend_Registry::get('Zend_Cache');
		$cache_id = $this->_getCacheId(array($row_id, $language));

		$cache->remove($cache_id);
	}

	/**
	 *
	 * @param type $row_id
	 * @param type $language
	 * @param type $create
	 * @return type
	 */
	protected function _fetchRow($row_id, $language, $create = false)
	{
		// prepare select
		$select = $this->select()->where('parent_id = ?', $row_id)->where('language = ?', $language);

		// fetch data
		$row = $this->fetchRow($select);

		if ($row == null && $create)
		{
			$row = $this->createRow(array('parent_id' => $row_id, 'language' => $language));
			$row->save();
		}

		return $row;
	}

	/**
	 *
	 * @param integer $row_id
	 * @param type $language
	 * @return type
	 */
	protected function _getCacheId(array $params)
	{
		return $this->_name . '_' . implode('_', $params);
	}

}