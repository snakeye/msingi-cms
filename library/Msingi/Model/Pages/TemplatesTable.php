<?php

/**
 * @package MsingiCms
 */
class Msingi_Model_Pages_TemplatesTable extends Msingi_Db_Table
{

	protected $_name = 'cms_page_templates';
	protected $_rowClass = 'Msingi_Model_Pages_Template';

	/**
	 *
	 * @return type
	 */
	public function fetchPairs()
	{
		$select = $this->select()->from($this, array('id', 'name'));

		return $this->getAdapter()->fetchPairs($select);
	}

}