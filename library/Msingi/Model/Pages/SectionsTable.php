<?php

class Msingi_Model_Pages_SectionsTable extends Msingi_Db_Table_Multilanguage
{

	protected $_name = 'cms_page_sections';
	protected $_rowClass = 'Msingi_Model_Pages_Section';
	protected $_referenceMap = array(
		'Pages' => array(
			'columns' => array('page_id'),
			'refTableClass' => 'Msingi_Model_Pages_Table',
			'refColumns' => array('id'),
			'onDelete' => self::CASCADE,
		)
	);

	/**
	 *
	 * @param type $page_id
	 * @param type $name
	 * @return \Msingi_Model_Pages_Section
	 */
	public function fetchSection($page_id, $name)
	{
		$select = $this->select()->where('page_id = ?', $page_id)->where('name = ?', $name);

		return $this->fetchRow($select);
	}

}