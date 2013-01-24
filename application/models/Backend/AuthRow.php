<?php

class Backend_AuthRow extends Msingi_Db_Table_Row
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
			$this->password = md5(Auth_Backend::SALT . $data['password1']);
		}
	}

}