<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Db_Table_Row_Multilanguage extends Msingi_Db_Table_Row
{

	protected $_texts = array();

	/**
	 * Localized texts
	 *
	 * @return type
	 */
	public function local()
	{
		return $this->getTexts(null, true);
	}

	/**
	 *
	 *
	 * @param string $language
	 * @param bool $create
	 * @return Msingi_Db_Table_Row
	 */
	public function getTexts($language = null, $create = false, $cache = true)
	{
		if ($language == null)
		{
			if (!Zend_Registry::isRegistered('Zend_Locale'))
				return null;

			$locale = Zend_Registry::get('Zend_Locale');

			$language = $locale->getLanguage();
		}

		if (!isset($this->_texts[$language]))
		{
			// this table
			$table = $this->getTable();
			if ($table == null)
			{
				// detached object
				$table = new $this->_tableClass();
			}

			// table with localized data
			$localizedTable = $table->getTextsTable();

			//
			$texts = $localizedTable->fetchTexts($this->id, $language, $create, $cache);

			$this->_texts[$language] = $texts;
		}

		return $this->_texts[$language];
	}

	/**
	 *
	 * @param array $data
	 */
	public function setFromArray(array $data)
	{
		parent::setFromArray($data);

//		$languages = array('en', 'cs');
//		foreach ($languages as $lang)
//		{
//			$texts = $this->getTexts($lang, true);
//			$texts->name = $data['name_' . $lang];
//			$texts->save();
//		}
	}

}