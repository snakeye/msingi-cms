<?php

/**
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Cms_File extends Msingi_Db_Table_Row
{

	/**
	 *
	 */
	public function getFile()
	{
		$attachements = $this->getAttachements();

		return $attachements->getFile($this->name);
	}

	/**
	 *
	 * @param type $file
	 */
	public function setFile($file)
	{
		$attachements = $this->getAttachements();

		$attachements->attachFile($file, $this->name);
	}

	/**
	 *
	 * @return \Msingi_Attachements
	 */
	protected function getAttachements()
	{
		return new Msingi_Attachements(array(
					'directory' => 'files/file-' . $this->id,
				));
	}

	/**
	 *
	 */
	public function delete()
	{
		$attachements = $this->getAttachements();

		$attachements->deleteFile($this->name);

		parent::delete();
	}

}