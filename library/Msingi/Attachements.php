<?php

/**
 *
 */
class Msingi_Attachements
{

	protected $_params;

	/**
	 *
	 * @param array $params
	 */
	public function __construct($params)
	{
		$this->_params = $params;
	}

	/**
	 *
	 * @param type $attachement_name
	 * @param type $name
	 * @return string
	 */
	public function getImage($attachement_name, $name)
	{
		$target = '/' . $this->_params['directory'] . '/' . $attachement_name;
		if ($name != '')
		{
			$target.= '-' . $name;
		}
		$target.= '.jpg';

		return $target;
	}

	/**
	 *
	 * @param type $file
	 * @param type $attachement_name
	 */
	public function attachImage($file, $attachement_name)
	{
		$content = Zend_Registry::get('Content');

		$target_dir = $content->dir . '/' . $this->_params['directory'];
		if (!is_dir($target_dir))
		{
			if (!mkdir($target_dir, 0775, true))
				return false;
		}

		//
		foreach ($this->_params['sizes'] as $name => $params)
		{
			//
			$params = explode(',', $params);

			//
			$size = $params[0];
			list($w, $h) = explode('x', $size);

			// crop
			$crop = in_array('crop', $params);

			//
			$target = $target_dir . '/' . $attachement_name . '-' . $name . '.jpg';

			//
			Msingi_Util_Image::resize($file, $target, $w, $h, $crop);
		}

		// save original
		$target = $target_dir . '/' . $attachement_name . '.jpg';
		copy($file, $target);

		return true;
	}

}