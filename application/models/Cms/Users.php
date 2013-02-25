<?php

/**
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Cms_Users extends Msingi_Db_Table
{

	protected $_name = 'cms_users';
	protected $_rowClass = 'Cms_User';

	const SALT = 'Msingi_Backend';

	/**
	 *
	 * @return string
	 */
	public static function getSalt()
	{
		return self::SALT;
	}

}