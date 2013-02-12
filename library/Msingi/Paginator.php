<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Paginator extends Zend_Paginator
{

	/**
	 *
	 * @param type $select
	 * @param type $page
	 * @param type $pages
	 * @return type
	 */
	public static function createFromSelect($select, $page, $pages)
	{
		$paginator = Msingi_Paginator::factory($select);
		$paginator->setItemCountPerPage($pages);
		$paginator->setCurrentPageNumber($page);

		return $paginator;
	}

}