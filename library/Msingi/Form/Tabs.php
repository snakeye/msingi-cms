<?php

class Msingi_Form_Tabs extends Msingi_Form
{

	/**
	 * Load default decorators
	 */
	public function loadDefaultDecorators()
	{
		parent::loadDefaultDecorators();

		// fix checkboxes
		foreach ($this->getElements() as $element)
		{
			if ($element->getType() == 'Zend_Form_Element_Checkbox')
			{
				$element->setDecorators(array(
					array('ViewHelper'),
					array('Label', array('placement' => 'APPEND')),
					array('HtmlTag', array('tag' => 'dd'))
				));
			}
		}

		// fix display groups
		foreach ($this->getDisplayGroups() as $display_group)
		{
			$display_group->setDecorators(array(
				'FormElements',
			));
		}


	}

}