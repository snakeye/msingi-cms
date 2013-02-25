<?php

/**
 * Language related constants
 *
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Cms_Constants_Languages
{

	const LABEL_NAME = 'name';
	const LABEL_NATIVE_NAME = 'native_name';
	const LABEL_LONG = 'long';

	// shared constants values
	protected static $s_values;
	//
	protected $_values;

	/**
	 * Default constructor
	 */
	public function __construct()
	{
		$class = get_called_class($this);

		// do we have stored categories for this class?
		if (!isset(self::$s_values[$class]))
		{
			$this->_values = $this->_getValues();

			// store static values
			self::$s_values[$class] = $this->_values;
		}
		else
		{
			// get static values
			$this->_values = self::$s_values[$class];
		}
	}

	/**
	 * Check if we have labels in required language
	 *
	 * @param string $code language code
	 * @return boolean
	 */
	public function isLanguage($code)
	{
		return in_array($code, array_keys($this->_values));
	}

	/**
	 * Get values
	 *
	 * @return array of values
	 */
	protected function _getValues()
	{
		$languages = array(
			'cs' => array(
				'name' => 'Czech',
				'native_name' => 'Čeština',
				'flag' => 'cz',
				'dir' => 'ltr',
				'regions' => array(
					'cz' => array(
						'name' => 'Czech Republic',
						'native_name' => 'Česko',
						'default' => true),
			)),
			'de' => array(
				'name' => 'German',
				'native_name' => 'Deutsch',
				'flag' => 'de',
				'dir' => 'ltr',
				'regions' => array(
					'de' => array(
						'name' => 'Germany',
						'native_name' => 'Deutschland',
						'default' => true),
			)),
			'en' => array(
				'name' => 'English',
				'native_name' => 'English',
				'flag' => 'gb',
				'dir' => 'ltr',
				'regions' => array(
					'us' => array(
						'name' => 'United States',
						'native_name' => 'United States',
						'default' => true),
					'gb' => array(
						'name' => 'Great Britain',
						'native_name' => 'Great Britain',
						'default' => false),
			)),
			'es' => array(
				'name' => 'Spanish',
				'native_name' => 'Español',
				'flag' => 'es',
				'dir' => 'ltr',
				'regions' => array(
					'ru' => array(
						'name' => 'Spain',
						'native_name' => 'España',
						'default' => true),
			)),
			'fr' => array(
				'name' => 'French',
				'native_name' => 'Français',
				'flag' => 'fr',
				'dir' => 'ltr',
				'regions' => array(
					'ru' => array(
						'name' => 'France',
						'native_name' => 'France',
						'default' => true),
			)),
			'ru' => array(
				'name' => 'Russian',
				'native_name' => 'Русский',
				'flag' => 'ru',
				'dir' => 'ltr',
				'regions' => array(
					'ru' => array(
						'name' => 'Russia',
						'native_name' => 'Россия',
						'default' => true),
			)),
		);

		return $languages;
	}

	/**
	 * Returns locale string for language
	 * If region is not set, default region is used
	 *
	 * @param string $language
	 * @param string $region
	 * @return string
	 */
	public function getLocale($language, $region = '')
	{
		if (!isset($this->_values[$language]))
			return '';

		$lang = $this->_values[$language];

		if ($region == '' || !isset($lang['regions'][$region]))
		{
			foreach ($lang['regions'] as $reg => $reg_desc)
			{
				if ($reg_desc['default'])
				{
					$region = $reg;
					break;
				}
			}
		}

		return $language . '_' . strtoupper($region);
	}

	/**
	 * Overrides base function with native names result
	 *
	 * @param boolean $with_empty include empty value
	 * @param string $label_field take label from this field
	 * @return array
	 */
	public function getPairs($with_empty = false, $label_field = Msingi_Model_Languages::LABEL_NAME)
	{
		$pairs = array();

		if ($with_empty)
		{
			$pairs[null] = '';
		}

		foreach ($this->_values as $id => $cat)
		{
			switch ($label_field)
			{
				case Msingi_Model_Languages::LABEL_NAME:
					// take label from name field
					$label = $cat['name'];
					break;
				case Msingi_Model_Languages::LABEL_NATIVE_NAME:
					// take label from native name
					$label = $cat['native_name'];
					break;
				case Msingi_Model_Languages::LABEL_LONG:
					// generate long label from name and native name
					$name = $cat['name'];
					$native_name = $cat['native_name'];
					if ($name == $native_name)
					{
						$label = $name;
					}
					else
					{
						$label = $name . ' (' . $native_name . ')';
					}
					break;
			}
			$pairs[$id] = $label;
		}

		return $pairs;
	}

	/**
	 * Get language name
	 *
	 * @param string $code language code
	 * @return string language name
	 */
	public function getName($code)
	{
		return $this->_values[$code]['name'];
	}

	/**
	 * Get language flag code
	 *
	 * @param string $code language code
	 * @return string flag code
	 */
	public function getFlag($code)
	{
		return $this->_values[$code]['flag'];
	}

	/**
	 * Get values as array
	 *
	 * @return array
	 */
	public function getArray()
	{
		return $this->_values;
	}

}