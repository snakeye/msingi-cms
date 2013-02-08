<?php

class Cms_Articles extends Msingi_Db_Table_Multilanguage
{

	protected $_name = 'cms_articles';
	protected $_rowClass = 'Cms_Article';

	/**
	 *
	 * @param type $limit
	 * @return type
	 */
	public function fetchRecent($limit = 5)
	{
		$select = $this->select()->order('date DESC')->limit($limit);

		return $this->fetchAll($select);
	}

	/**
	 *
	 * @return type
	 */
	public function selectAllArticles()
	{
		$select = $this->select()->order('date DESC');

		return $select;
	}

}