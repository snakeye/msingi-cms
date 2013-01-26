<?php

/**
 *
 */
class Cms_MailTemplate extends Msingi_Db_Table_Row_Multilanguage
{

	/**
	 * @todo move to base class
	 * @param array $data
	 */
	public function setFromArray(array $data)
	{
		parent::setFromArray($data);

		//$languages = Msingi_Application_Settings::getInstance()->getArray('multilanguage:languages');
		$languages = Msingi_Application_Settings::getInstance()->getArray('section:frontend:languages:enabled');

		foreach ($languages as $lang)
		{
			$texts = $this->getTexts($lang, true, false);
			$texts->subject = $data['subject_' . $lang];
			$texts->template = $data['template_' . $lang];
			$texts->save();
		}
	}

}