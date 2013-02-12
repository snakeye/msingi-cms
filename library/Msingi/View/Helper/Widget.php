<?php

/**
 * View helper to display widgets
 *
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_View_Helper_Widget extends Zend_View_Helper_Abstract
{

	/**
	 *
	 * @param string $position
	 * @return string
	 */
	public function widget($position, $language = null)
	{
		$ret = '';

		$widgets = Cms_Widgets::getInstance();

		$widget = $widgets->fetchWidget($position);
		if ($widgets != null)
		{
			if ($language == null)
			{
				$language = $this->view->language();
			}

			$texts = $widget->getTexts($language, true);

			$ret .= $texts->text;
		}

		return $ret;
	}

}