<?php

/**
 * @package MsingiCms
 */
class Cms_DictionaryLabels extends Msingi_Db_Table
{

	protected $_name = 'cms_dictionary_labels';
	protected $_referenceMap = array(
		'Dictionary' => array(
			'columns' => 'row_id',
			'refTableClass' => 'Cms_Dictionaries',
			'refColumns' => 'id',
			'onDelete' => self::CASCADE,
		),
	);

	/**
	 *
	 * @param type $row_id
	 * @param type $language
	 * @return type
	 */
	public function fetch($row_id, $language)
	{
		$select = $this->select()->where('row_id = ?', $row_id)->where('language = ?', $language);

		return $this->fetchRow($select);
	}

}