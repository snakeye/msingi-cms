<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Controller extends Zend_Controller_Action implements Msingi_Translator_Interface
{

	// current locale
	protected $_locale;
	// translator object
	protected $_translator;
	// default translator
	protected static $_translatorDefault;

	/**
	 * Get current language
	 *
	 * @return string current language
	 */
	public function language()
	{
		$locale = $this->locale();
		if ($locale != null)
			return $locale->getLanguage();

		return '';
	}

	/**
	 * Get current locale
	 *
	 * @return string current locale
	 */
	public function locale()
	{
		if ($this->_locale == null)
		{
			if (Zend_Registry::isRegistered('Zend_Locale'))
				$this->_locale = Zend_Registry::get('Zend_Locale');
		}
		return $this->_locale;
	}

	/**
	 * Translate string
	 *
	 * @param string $string string to translate
	 * @return string
	 */
	public function translate($string)
	{
		$translator = $this->getTranslator();

		return $translator->translate($string);
	}

	/**
	 * Short-hand alias for translate function
	 *
	 * @param string $string
	 * @return string
	 */
	public function _($string)
	{
		return $this->translate($string);
	}

	/**
	 * Wrapper for sprintf() function. First argument is translated
	 *
	 * @param string $string
	 * @return string
	 */
	public function _s($string)
	{
		$arg_list = func_get_args();

		$arg_list[0] = $this->translate($arg_list[0]);

		return call_user_func_array('sprintf', $arg_list);
	}

	/**
	 * Get current translator object
	 *
	 * @return \Zend_Translate
	 */
	public function getTranslator()
	{
		if ($this->_translator == null)
		{
			if (Zend_Registry::isRegistered('Zend_Translate'))
				$this->_translator = Zend_Registry::get('Zend_Translate');
		}

		return $this->_translator;
	}

	/**
	 *
	 * @param type $translator
	 * @throws Zend_Form_Exception
	 */
	public static function setDefaultTranslator($translator = null)
	{
		if (null === $translator)
		{
			self::$_translatorDefault = null;
		}
		elseif ($translator instanceof Zend_Translate_Adapter)
		{
			self::$_translatorDefault = $translator;
		}
		elseif ($translator instanceof Zend_Translate)
		{
			self::$_translatorDefault = $translator->getAdapter();
		}
		else
		{
			require_once 'Zend/Form/Exception.php';
			throw new Zend_Form_Exception('Invalid translator specified');
		}
	}

	/**
	 * Handle AJAX responses
	 */
	public function ajaxResponse()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();

		$response = $this->getResponse();
		$response->setCacheControl(false);
	}

}