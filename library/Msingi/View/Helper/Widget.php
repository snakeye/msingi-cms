<?php

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

		$widgets = new Cms_Widgets();

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