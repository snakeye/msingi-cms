<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Model_Pages_Page extends Msingi_Db_Table_Row_Multilanguage
{

	const TYPE_PATH = 'path';
	const TYPE_REQUEST = 'request';

	protected $subpages;

	/**
	 *
	 * @return boolean
	 */
	public function hasSubpages()
	{
		if ($this->subpages == null)
		{
			$this->subpages = $this->subpages();
		}

		return $this->subpages != null && count($this->subpages) > 0;
	}

	/**
	 *
	 * @return type
	 */
	public function subpages()
	{
		if ($this->subpages == null)
		{
			$pages = new Msingi_Model_Pages_PagesTable();

			$this->subpages = $pages->fetchSubpages($this->id);
		}

		return $this->subpages;
	}

	/**
	 *
	 * @return string
	 */
	public function pathLast()
	{
		switch ($this->type)
		{
			case Msingi_Model_Pages_Page::TYPE_PATH:
				return $this->path;
			case Msingi_Model_Pages_Page::TYPE_REQUEST:
				$path = explode(':', $this->path);
				$ret = array();
				if ($path[0] != 'default')
					$ret[] = $path[0];
				if ($path[1] != 'index')
					$ret[] = $path[1];
				if ($path[2] != 'index')
					$ret[] = $path[2];
				if (count($ret) == 0)
					return '/';
				return implode('/', $ret);
		}
		return '';
	}

	/**
	 *
	 * @return \Msingi_Model_Pages_Page
	 */
	public function parent()
	{
		$pages = new Msingi_Model_Pages_PagesTable();

		return $pages->fetchById($this->parent_id);
	}

	/**
	 *
	 * @return page sections rowset
	 */
	public function sections()
	{
		$page_sections = new Msingi_Model_Pages_SectionsTable();

		return $page_sections->fetchByPage($this->id);
	}

	/**
	 *
	 * @param type $name
	 * @param type $create
	 * @return \Cms_PageSection
	 */
	public function section($name, $create = true)
	{
		$page_sections = new Msingi_Model_Pages_SectionsTable();

		$page_section = $page_sections->fetchSection($this->id, $name);
		if ($page_section == null && $create)
		{
			$page_section = $page_sections->createRow(array(
				'page_id' => $this->id,
				'name' => $name,
					));

			$page_section->save();
		}

		return $page_section;
	}

	/**
	 *
	 * @return type
	 */
	public function template()
	{
		$templates = new Msingi_Model_Pages_TemplatesTable();

		return $templates->fetchById($this->template_id);
	}

	/**
	 *
	 * @param string $language language for content
	 * @param boolean $skip_cache skip caching
	 * @return array
	 * @todo caching
	 */
	public function content($language, $skip_cache = false)
	{
		$page_sections = new Msingi_Model_Pages_SectionsTable();

		$select = $page_sections->select()->from($page_sections, array('name'))
				->joinLeft('cms_page_sections_texts', 'cms_page_sections_texts.parent_id = cms_page_sections.id', array('content'))
				->where('page_id = ?', $this->id)
				->where('language = ?', $language)
				->setIntegrityCheck(false);

		return $page_sections->getAdapter()->fetchPairs($select);
	}

	/**
	 * Returns URL for menu
	 *
	 * @return string
	 */
	public function getMenuUrl()
	{
		switch ($this->type)
		{
			case Msingi_Model_Pages_Page::TYPE_PATH:
				$page = $this;
				$path = array();
				do
				{
					if ($page->parent_id != null)
						$path[] = $page->path;
				}
				while (($page = $page->parent()) != null);
				return '/' . implode('/', array_reverse($path));

			case Msingi_Model_Pages_Page::TYPE_REQUEST:
				return $this->path;
		}
		return '';
	}

}