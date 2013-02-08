<?php

class Form_File extends Msingi_Form
{

	public function init()
	{
		parent::init();

		$this->setAction('/files/index/edit');
		$this->setMethod('post');

		$this->addElement('hidden', 'id');

		$file = $this->createElement('file', 'file', array(
			'label' => $this->_('File'),
				));

		//$photo->setDestination($dir->temp);
		$file->addValidator('Count', false, 1);
		//$photo->addValidator('Size', false, 1024 * 1024);
		//$image->addValidator('Extension', false, 'jpg,png,gif');

		$this->addElements(array($file));

		// submit button
		$submit = $this->createElement('submit', 'submit', array(
			'required' => false,
			'ignore' => true,
			'label' => $this->_('Save'),
			'class' => 'btn btn-primary',
				));

		$this->addElement($submit);
	}

}