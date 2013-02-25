<?php

/**
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Cms_User extends Msingi_Db_Table_Row
{

	/**
	 *
	 * @param array $data
	 */
	public function setFromArray(array $data)
	{
		parent::setFromArray($data);

		if (isset($data['password1']) && $data['password1'] != '' && $data['password1'] == $data['password2'])
		{
			$this->password = md5(Cms_Users::SALT . $data['password1']);
		}
	}

}