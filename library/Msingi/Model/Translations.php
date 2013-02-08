<?php

class Msingi_Model_Translations extends Msingi_Db_Table
{

	protected $_name = 'cms_translations';

	/**
	 *
	 * @param type $language
	 * @return type
	 */
	public function fetchTranslations($language)
	{
		$select = $this->select()->from($this, array('message_id', 'translation'))
				->where('language = ?', $language)
				->where('translation != ""');

		return $this->getAdapter()->fetchPairs($select);
	}

	/**
	 *
	 * @param type $messageId
	 * @param type $locale
	 */
	public function addTranslation($messageId, $locale)
	{
		$language = substr($locale, 0, 2);

		$select = $this->select()->where('language = ?', $language)->where('message_id = ?', $messageId);

		$row = $this->fetchRow($select);
		if ($row == null)
		{
			$row = $this->createRow(array(
				'language' => $language,
				'message_id' => $messageId,
				'translation' => '',
					));

			$row->save();
		}
	}

	/**
	 *
	 * @param type $language
	 * @param type $filter
	 */
	public function selectAll($language, $filter = null)
	{
		$select = $this->select()
				->where('language = ?', $language)
				->order('message_id ASC');

		if ($filter != null)
		{
			if ($filter['search'] != '')
			{
				$search = $this->getAdapter()->quote('%' . trim($filter['search']) . '%');
				$select->where('message_id LIKE ' . $search);
			}

			if ($filter['untranslated'])
			{
				$select->where('translation = ""');
			}
		}

		return $select;
	}

}