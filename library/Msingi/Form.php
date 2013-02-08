<?php

class Msingi_Form extends Zend_Form implements Msingi_Translator
{

	protected $_locale;

	/**
	 *
	 */
	public function init()
	{
		$this->addPrefixPath('Msingi_Form', 'Msingi/Form/');
	}

	/**
	 *
	 * @param type $action
	 */
	public function setAction($action)
	{
		$currentSection = Zend_Registry::get('CurrentSection');

		$action = $currentSection->url($action);

		return parent::setAction($action);
	}

	/**
	 *
	 * @param type $values
	 */
	public function populate($values)
	{
		if (is_object($values))
		{
			parent::populate($values->toArray());
		}
		if (is_array($values))
		{
			parent::populate($values);
		}
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
		if (!Zend_Registry::isRegistered('Zend_Translate'))
			return $string;

		$t = Zend_Registry::get('Zend_Translate');

		return $t->translate($string);
	}

	/**
	 *
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
	 * Load default decorators
	 */
	public function loadDefaultDecorators()
	{
		parent::loadDefaultDecorators();

		// remove decorators from hidden elements
		foreach ($this->getElements() as $element)
		{
			if ($element->getType() == 'Zend_Form_Element_Hidden')
			{
				$element->removeDecorator('Label')->removeDecorator('HtmlTag');
			}

			if ($element->getType() == 'Zend_Form_Element_Submit')
			{
				$element->removeDecorator('Label');
			}
		}
	}

}