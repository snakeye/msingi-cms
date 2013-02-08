<?php

/**
 * @package Msingi
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

	/**
	 *
	 * @param type $userParams
	 * @param type $name
	 * @param type $reset
	 * @param type $encode
	 */
	public function assemble($userParams, $name = null, $reset = false, $encode = true)
	{
		$root = '';

		$sections = Zend_Registry::get('Sections');
		if (isset($userParams['section']) && $userParams['section'] != '')
		{
			$section = $sections->getSection($userParams['section']);
			if ($section == null)
			{
				throw new Zend_Exception(sprintf('Undefined section "%s"', $userParams['section']));
			}
		}
		else
		{
			$section = $sections->getCurrentSection();
		}

		unset($userParams['section']);

		$root = $section->root();

		$path = rtrim($root, '/') . parent::assemble($userParams, $name, $reset, $encode);

		return $path;
	}

}