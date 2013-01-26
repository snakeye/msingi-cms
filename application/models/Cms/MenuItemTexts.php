<?php

class Cms_MenuItemTexts extends Msingi_Db_Table_Multilanguage
{

	protected $_name = 'menu_texts';
	protected $_referenceMap = array(
		'Parent' => array(
			'columns' => 'parent_id',
			'refTableClass' => 'Cms_MenuItems',
			'refColumns' => 'id',
			'onDelete' => self::CASCADE,
		),
	);

}