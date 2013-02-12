<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_View extends Zend_View implements Msingi_Translator_Interface
{

	protected $_locale;
	protected $_translator;
	protected static $_translatorDefault;

	/**
	 *
	 * @param type $config
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

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
	 * @return type
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
		if ($translator == null)
			return $string;

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
	 * Wrapper for sprintf function
	 *
	 * @param type $string
	 * @return type
	 */
	public function _s($string)
	{
		$arg_list = func_get_args();

		$arg_list[0] = $this->translate($arg_list[0]);

		return call_user_func_array('sprintf', $arg_list);
	}

	/**
	 *
	 */
	public function getTranslator()
	{
		if ($this->_translator == null)
		{
			if (self::$_translatorDefault == null)
			{
				if (Zend_Registry::isRegistered('Zend_Translate'))
				{
					$translator = Zend_Registry::get('Zend_Translate');
					if ($translator instanceof Zend_Translate_Adapter)
					{
						$this->_translator = $translator;
					}
					elseif ($translator instanceof Zend_Translate)
					{
						$this->_translator = $translator->getAdapter();
					}
				}
			}
			else
			{
				$this->_translator = self::$_translatorDefault;
			}
		}

		return $this->_translator;
	}

	/**
	 *
	 * @param type $translator
	 */
	public function setTranslator($translator)
	{
		$this->_translator = $translator;
	}

	/**
	 * Set DOCTYPE
	 *
	 * @param string $doctype
	 * @param string charset UTF-8 by default
	 * @throws Zend_Exception
	 */
	public function setDoctype($doctype, $charset = 'UTF-8')
	{
		switch ($doctype)
		{
			case 'HTML5':
				$this->doctype('HTML5');
				$this->headMeta()->setCharset($charset);
				// for old IE
				$this->headScript()->prependFile('//html5shim.googlecode.com/svn/trunk/html5.js', 'text/javascript', array('conditional' => 'lt IE 9'));
				break;
			case 'XHTML1_TRANSITIONAL':
				$this->doctype('XHTML1_TRANSITIONAL');
				$this->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=' . $charset);
				break;
			default:
				throw new Zend_Exception('Unsupported doctype: ' . $doctype);
		}
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

}