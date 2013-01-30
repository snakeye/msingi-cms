<?php

/**
 * Multilanguage table with structure
 * id - type - name
 *
 * @package MsingiCms
 */
class Cms_Dictionaries extends Msingi_Db_Table
{

	protected $_name = 'cms_dictionary';
	protected $_dependentTables = array('Cms_DictionaryLabels');

	/**
	 *
	 * @param type $type
	 * @param type $name
	 */
	public function findId($type, $name)
	{
		$select = $this->select()->from($this, array('id'))
			->where('type = ?', $type)
			->where('name = ?', $name);

		return $this->getAdapter()->fetchOne($select);
	}

	/**
	 *
	 * @param type $type
	 */
	public function fetchLabels($type)
	{
		$select = $this->select()->from($this, array('id', 'name'))
			->joinLeft('cms_dictionary_labels', 'row_id = cms_dictionary.id', array('language', 'label'))
			->where('type = ?', $type)
			->setIntegrityCheck(false);

		$data = $this->fetchAll($select);

		$ret = array();

		foreach ($data as $row)
		{
			$ret[$row->name][$row->language] = $row->label;
		}

		return $ret;
	}

	/**
	 *
	 * @param type $type
	 * @param type $name
	 * @param type $language
	 * @param type $label
	 */
	public function setLabel($type, $name, $language, $label)
	{
		$select = $this->select()->where('type = ?', $type)->where('name = ?', $name);

		$row = $this->fetchRow($select);

		if ($row != null)
		{
			$labels = new Cms_DictionaryLabels();

			$label_row = $labels->fetch($row->id, $language);

			if ($label_row == null)
			{
				$label_row = $labels->createRow(array(
					'row_id' => $row->id,
					'language' => $language,
					));
			}

			$label_row->label = $label;

			$label_row->save();
		}
	}

}