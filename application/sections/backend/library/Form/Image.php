<?php

class Form_Image extends Msingi_Form_Tabs
{

	public function init()
	{
		parent::init();

		$this->setAction('/images/index/edit');
		$this->setMethod('post');

		$this->addElement('hidden', 'id');

		$image = $this->createElement('file', 'image', array(
			'label' => $this->_('Image file'),
			));

		//$photo->setDestination($dir->temp);
		$image->addValidator('Count', false, 1);
		//$photo->addValidator('Size', false, 1024 * 1024);
		$image->addValidator('Extension', false, 'jpg,png,gif');

		$this->addElements(array($image));

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