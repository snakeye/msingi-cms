<?php

/**
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Cms_MenuItemTexts extends Msingi_Db_Table
{

	protected $_name = 'cms_menu_texts';
	protected $_referenceMap = array(
		'Parent' => array(
			'columns' => 'parent_id',
			'refTableClass' => 'Cms_MenuItems',
			'refColumns' => 'id',
			'onDelete' => self::CASCADE,
		),
	);

}