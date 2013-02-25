<?php

/**
 * Blog/news articles
 *
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Cms_Articles extends Msingi_Db_Table_Multilanguage
{

	protected $_name = 'cms_articles';
	protected $_rowClass = 'Cms_Article';

	/**
	 * Fetch most recent articles
	 *
	 * @param integer $limit number of articles to fetch
	 * @return Zend_Db_Table_Rowset
	 */
	public function fetchRecent($limit = 5)
	{
		$select = $this->select()->where('status = ?', Cms_Article::STATUS_PUBLISHED)
						->order('date DESC')->limit($limit);

		return $this->fetchAll($select);
	}

	/**
	 * Generate select operator for all articles sorted by date
	 *
	 * @return Zend_Db_Select
	 */
	public function selectAllArticles()
	{
		$select = $this->select()->order('date DESC');

		return $select;
	}

}