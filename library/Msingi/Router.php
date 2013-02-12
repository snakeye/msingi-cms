<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
abstract class Msingi_Router extends Zend_Controller_Router_Rewrite
{

	protected $_currentSection;

	/**
	 *
	 * @param type $currentSection
	 */
	public function setCurrentSection($currentSection)
	{
		$this->_currentSection = $currentSection;
	}

	/**
	 *
	 * @param string $locale_code
	 */
	protected function initLocale($locale_code)
	{
		// create locale
		$locale = new Zend_Locale($locale_code);

		Zend_Registry::set('Zend_Locale', $locale);

		// Translator for validators
		$translator = new Zend_Translate('array', realpath(APPLICATION_PATH . '/resources/languages'), $locale->getLanguage(), array(
					'scan' => Zend_Translate::LOCALE_DIRECTORY,
					'disableNotices' => true,
				));

		Zend_Validate_Abstract::setDefaultTranslator($translator);

		//
		$site = Zend_Registry::get('Sections');
		$section = $site->getCurrentSection()->name();

		//
		$languages_path = realpath(APPLICATION_PATH . '/sections/' . $section . '/resources/languages');

		// Application Translator
		$translator = new Zend_Translate('gettext', $languages_path, $locale->getLanguage(), array(
					'scan' => Zend_Translate::LOCALE_FILENAME,
					'disableNotices' => true,
				));
		Zend_Registry::set('Zend_Translate', $translator);

		// set this translator
		//Zend_Form::setDefaultTranslator($translator);
		Msingi_View::setDefaultTranslator($translator);
		Msingi_Controller::setDefaultTranslator($translator);
	}

}