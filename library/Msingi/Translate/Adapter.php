<?php

/**
 * Adapter for Zend_Translator. Uses database as translations storage
 * 
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Translate_Adapter extends Zend_Translate_Adapter
{

	/**
	 *
	 * @param type $data
	 * @param type $locale
	 * @param array $options
	 * @return type
	 */
	protected function _loadTranslationData($data, $locale, array $options = array())
	{
		$temp = explode('_', $locale);
		$language = $temp[0];

		$this->_translate[$locale] = Msingi_Model_Translations::getInstance()->fetchTranslations($language);

		return $this->_translate;
	}

	/**
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'MsingiDb';
	}

	/**
	 *
	 * @param type $messageId
	 * @param type $locale
	 * @return type
	 */
	public function translate($messageId, $locale = null)
	{
		if ($locale === null)
		{
			$locale = $this->_options['locale'];
		}

		// add translation if there is no one
		if (!isset($this->_translate[$locale][$messageId]))
			Msingi_Model_Translations::getInstance()->addTranslation($messageId, $locale);

		return parent::translate($messageId, $locale);
	}

}