<?php

class Msingi_View_Helper_Content extends Zend_View_Helper_Abstract
{

	/**
	 *
	 * @param string $file file path
	 * @param string $default default file
	 * @return string
	 */
	public function content($file = '', $default = '')
	{
		if (Zend_Registry::isRegistered('Content'))
		{
			$content = Zend_Registry::get('Content');

			// no file given, just content root
			if ($file == '')
				return $content->url;

			// check the file exists
			if (!is_file($content->dir . '/' . $file))
			{
				return $default;
			}

			//
			$url = parse_url($content->url . $file);

			//
			return Msingi_Util_Http::build_url($url);
		}

		// Site is undefined
		return '';
	}

}