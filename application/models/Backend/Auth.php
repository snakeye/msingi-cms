<?php

class Backend_Auth extends Msingi_Db_Table
{

	protected $_name = 'auth_backend';
	protected $_rowClass = 'Backend_AuthRow';

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