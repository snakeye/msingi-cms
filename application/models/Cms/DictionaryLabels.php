<?php

/**
 * Language dependent labels for dictionary
 *
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Cms_DictionaryLabels extends Msingi_Db_Table
{

	// table name
	protected $_name = 'cms_dictionary_labels';
	// table references
	protected $_referenceMap = array(
		'Dictionary' => array(
			'columns' => 'row_id',
			'refTableClass' => 'Cms_Dictionaries',
			'refColumns' => 'id',
			'onDelete' => self::CASCADE,
		),
	);

	/**
	 * Fetch label for given row in given language
	 *
	 * @param integer $row_id dictionary row id
	 * @param string $language language code
	 * @return Zend_Db_Table_Row
	 */
	public function fetch($row_id, $language)
	{
		$select = $this->select()->where('row_id = ?', $row_id)->where('language = ?', $language);

		return $this->fetchRow($select);
	}

}