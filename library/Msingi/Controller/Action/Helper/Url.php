<?php

class Msingi_Controller_Action_Helper_Url extends Zend_Controller_Action_Helper_Url
{

	/**
	 *
	 * @param type $urlOptions
	 * @param type $name
	 * @param type $reset
	 * @param type $encode
	 * @return type
	 */
	public function url($urlOptions = array(), $name = null, $reset = false, $encode = true)
	{
		if (!isset($urlOptions['section']))
		{
			$sections = Zend_Registry::get('Sections');

			$currentSection = $sections->getCurrentSection();

			$urlOptions['section'] = $currentSection->name();
		}

		return parent::url($urlOptions, $name, $reset, $encode);
	}

}
