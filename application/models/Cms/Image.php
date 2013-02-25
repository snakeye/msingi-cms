<?php

/**
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Cms_Image extends Msingi_Db_Table_Row
{

	/**
	 *
	 */
	public function getImage($size = '')
	{
		$attachements = $this->getAttachements();

		return $attachements->getImage('image', $size);
	}

	/**
	 *
	 * @param type $file
	 */
	public function setImage($file)
	{
		$attachements = $this->getAttachements();

		$attachements->attachImage($file, 'image');
	}

	/**
	 *
	 * @return \Msingi_Attachements
	 */
	protected function getAttachements()
	{
		return new Msingi_Attachements(array(
				'directory' => 'images/image-' . $this->id,
				'sizes' => array(
					'icon' => '60x60,crop',
					'thumbnail' => '100x100,crop',
					'small' => '150x150',
					'medium' => '300x300',
					'large' => '600x600',
				),
			));
	}

}