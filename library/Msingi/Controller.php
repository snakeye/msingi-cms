<?php

/**
 * @package Msingi
 */
class Msingi_Controller extends Zend_Controller_Action implements Msingi_Translator
{

	protected $_locale;
	protected $_translator;
	protected static $_translatorDefault;

	/**
	 *
	 * @return string
	 */
	public function language()
	{
		$locale = $this->locale();
		if ($locale != null)
			return $locale->getLanguage();

		return '';
	}

	/**
	 *
	 * @return string
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
	 *
	 * @param type $string
	 * @return type
	 */
	public function translate($string)
	{
		$translator = $this->getTranslator();
		return $translator->translate($string);
	}

	/**
	 *
	 * @param string $string
	 */
	public function _($string)
	{
		return $this->translate($string);
	}

	/**
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
	 *
	 * @return \Zend_Translate|\Msingi_Translator_Dummy
	 */
	public function getTranslator()
	{
		if ($this->_translator == null)
		{
			if (Zend_Registry::isRegistered('Zend_Translate'))
				$this->_translator = Zend_Registry::get('Zend_Translate');
			else
				$this->_translator = new Msingi_Translator_Dummy();
		}

		return $this->_translator;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getLog()
	{
		$bootstrap = $this->getInvokeArg('bootstrap');

		if ($bootstrap != null)
		{
			if (!$bootstrap->hasResource('Log'))
			{
				return false;
			}

			return  $bootstrap->getResource('Log');
		}
		
		return false;
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
	 * Update response to handle AJAX
	 */
	public function ajaxResponse()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();

		$response = $this->getResponse();
		$response->setCacheControl(false);
	}

}