<?php

/**
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Cms_Widget extends Msingi_Db_Table_Row_Multilanguage
{

	/**
	 *
	 * @param array $data
	 */
	public function setFromArray(array $data)
	{
		parent::setFromArray($data);

		if ($this->id != 0)
		{
		$languages = Msingi_Model_Settings::getInstance()->getArray('section:frontend:languages:enabled');

			foreach ($languages as $lang)
			{
				$texts = $this->getTexts($lang, true, false);
				$texts->text = $data['text_' . $lang];
				$texts->save();
			}
		}
	}

}