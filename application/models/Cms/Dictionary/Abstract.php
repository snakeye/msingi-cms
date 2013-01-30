<?php

/**
 * Abstract class for user defined dictionaries
 *
 * @package MsingiCms
 */
abstract class Cms_Dictionary_Abstract extends Cms_Dictionaries
{

	protected $_dictionary = array();

	abstract protected function _getType();

	/**
	 *
	 * @param type $language
	 * @param type $with_empty
	 */
	public static function getOptions($language, $with_empty = false)
	{
		$table = new static;

		return $table->getPairs($language, $with_empty);
	}

	/**
	 *
	 * @param type $language
	 * @return type
	 */
	public function getPairs($language, $with_empty = false)
	{
		if (!isset($this->_dictionary[$language]))
		{
			$this->_dictionary[$language] = $this->fetchDictionary($language);
		}

		//
		if ($with_empty)
		{
			return array_merge(array(null => ''), $this->_dictionary[$language]);
		}

		return $this->_dictionary[$language];
	}

	/**
	 * Get pairs filtering some values
	 *
	 * @param array $except
	 * @param string $language
	 * @return array
	 */
	public function getPairsExcept($except, $language)
	{
		if (!isset($this->_dictionary[$language]))
		{
			$this->_dictionary[$language] = $this->fetchDictionary($language);
		}

		// collect filtered values
		$ret = array();
		foreach ($this->_dictionary[$language] as $name => $label)
		{
			if (!in_array($name, $except))
			{
				$ret[$name] = $label;
			}
		}

		return $ret;
	}

	/**
	 * @todo do we really need language here?
	 *
	 * @param type $name
	 * @return type
	 */
	public function hasKey($name, $language)
	{
		if (!isset($this->_dictionary[$language]))
		{
			$this->_dictionary[$language] = $this->fetchDictionary($language);
		}

		return array_key_exists($name, $this->_dictionary[$language]);
	}

	/**
	 *
	 * @param int $id
	 * @return string
	 */
	public function getLabel($name, $language)
	{
		if (!isset($this->_dictionary[$language]))
		{
			$this->_dictionary[$language] = $this->fetchDictionary($language);
		}

		return $this->_dictionary[$language][$name];
	}

	/**
	 *
	 * @param type $language
	 * @return type
	 */
	protected function fetchDictionary($language)
	{
		if ($language == null)
			throw new Exception('Dictionary::fetchDictionary requires language');

		$cache = Zend_Registry::get('Zend_Cache');
		$cache_id = $this->_getCacheId(array($this->_getType(), $language));

		if (($dictionary = $cache->load($cache_id)) === false)
		{
			// table with translations
			$texts_table = $this->_name . '_labels';

			// construct select
			$select = $this->select()->from($this, array('id', 'name'))
					->joinLeft($texts_table, $this->_name . '.id = ' . $texts_table . '.row_id', array('label'))
					->where('type = ?', $this->_getType())
					->where('language = ?', $language)
					->order('label ASC')
					->setIntegrityCheck(false);

			// result
			$dictionary = array();

			// collect data
			foreach ($this->fetchAll($select) as $row)
			{
				// @todo ??? $row->name ???
				$dictionary[$row->name] = $row->label;
			}

			$cache->save($dictionary, $cache_id);
		}

		return $dictionary;
	}

	/**
	 *
	 * @param type $name
	 * @return type
	 */
	protected function _getCacheId(array $params)
	{
		return 'dictionary_' . implode('_', $params);
	}

}