<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Model_Pages_PagesTable extends Msingi_Db_Table_Multilanguage
{

	protected $_name = 'cms_pages';
	protected $_rowClass = 'Msingi_Model_Pages_Page';
	protected $_dependentTables = array('Msingi_Model_Pages_SectionsTable');

	/**
	 *
	 * @return \Msingi_Model_Pages_Page
	 */
	public function fetchRoot()
	{
		$select = $this->select()->where('parent_id IS NULL');

		return $this->fetchRow($select);
	}

	/**
	 *
	 * @param type $page_id
	 * @return type
	 */
	public function fetchSubpages($page_id)
	{
		$select = $this->select()->where('parent_id = ?', $page_id)->order('type')->order('path');

		return $this->fetchAll($select);
	}

	/**
	 *
	 * @param type $route
	 * @return \Msingi_Model_Pages_Page
	 */
	public function fetchPage($path)
	{
		$select = $this->select()->where('path = ?', $path);

		// fetch page
		return $this->fetchRow($select);
	}

	/**
	 *
	 * @param Zend_Controller_Request $request
	 * @param boolean $create
	 * @return Msingi_Model_Pages_Page
	 */
	public function fetchByRequest($request, $create = false)
	{
		// construct route
		$path = $request->getModuleName() . ':' . $request->getControllerName() . ':' . $request->getActionName();

		// fetch page
		$page = $this->fetchPage($path);

		// page not found, create it if needed
		if ($page == null && $create)
		{
			$page = $this->createRow(array(
				'parent_id' => 1,
				'can_delete' => 0,
				'type' => Msingi_Model_Pages_Page::TYPE_REQUEST,
				'path' => $path,
					));

			$page->save();
		}

		return $page;
	}

	/**
	 *
	 * @todo cache
	 * @param type $path
	 * @param type $create
	 * @return \Msingi_Model_Pages_Page
	 */
	public function fetchByPath($path, $create = false)
	{
		$root = $this->fetchRoot();

		$path = trim($path, '/');
		// root page is always controlled
		if ($path == '')
			return null;

		$path = explode('/', $path);

		return $this->_searchPath($root, $path, $create);
	}

	/**
	 *
	 * @todo cache
	 * @param type $page
	 * @param type $path
	 * @return \Msingi_Model_Pages_Page
	 */
	protected function _searchPath($page, $path, $create = false)
	{
		$dir = array_shift($path);

		$select = $this->select()->where('type = ?', Msingi_Model_Pages_Page::TYPE_PATH)
				->where('parent_id = ?', $page->id)
				->where('path = ?', $dir);

		// fetch page
		$row = $this->fetchRow($select);

		// not found
		if ($row == null)
		{
			if ($create)
			{
				// create new page
				$row = $this->createRow(array(
					'parent_id' => 1,
					'can_delete' => 0,
					'type' => Msingi_Model_Pages_Page::TYPE_PATH,
					'path' => $dir,
						));

				$row->save();
			}
			else
			{
				return null;
			}
		}

		if (count($path) == 0)
			return $row;

		return $this->_searchPath($row, $path, $create);
	}

}