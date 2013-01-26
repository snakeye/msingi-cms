<?php

class Cms_Widget extends Msingi_Db_Table_Row_Multilanguage
{

	public function setFromArray(array $data)
	{
		parent::setFromArray($data);

		if ($this->id != 0)
		{
			$languages = Settings::getInstance()->getArray('multilanguage:languages');

			foreach ($languages as $lang)
			{
				$texts = $this->getTexts($lang, true, false);
				$texts->text = $data['text_' . $lang];
				$texts->save();
			}
		}
	}

}