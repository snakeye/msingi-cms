<?php

class Form_Settings extends Msingi_Form
{

	/**
	 *
	 */
	public function init()
	{
		$this->setAction('/settings');
		$this->setMethod('post');

		$this->addElement('hidden', 'section');
	}

	/**
	 *
	 * @param type $settings
	 */
	public function createElements($settings)
	{
		foreach ($settings as $setting)
		{
			switch ($setting['type'])
			{
				case 'string':
					$element = $this->createElement('text', $setting['name']);
					if (isset($setting['label']))
						$element->setLabel($setting['label']);
					if (isset($setting['description']))
						$element->setDescription($setting['description']);
					$this->addElement($element);
					break;
				case 'text':
					$element = $this->createElement('textarea', $setting['name'], array(
						));
					if (isset($setting['label']))
						$element->setLabel($setting['label']);
					if (isset($settings['description']))
						$element->setDescription($setting['description']);
					$this->addElement($element);
					break;
				case 'checkbox':
					$element = $this->createElement('checkbox', $setting['name']);
					if (isset($setting['label']))
						$element->setLabel($setting['label']);
					if (isset($settings['description']))
						$element->setDescription($setting['description']);
					$this->addElement($element);
					break;
				case 'multicheckbox':
					$element = $this->createElement('multiCheckbox', $setting['name'], array(
						'label_class' => 'checkbox multicheckbox',
						'separator' => ' ',
						));
					if (isset($setting['label']))
						$element->setLabel($setting['label']);
					$element->addMultiOptions($setting['options']);
					if (isset($settings['description']))
						$element->setDescription($setting['description']);
					$this->addElement($element);
					break;
				case 'radio':
					$element = $this->createElement('radio', $setting['name'], array(
						'label_class' => 'radio',
						'separator' => ' ',
						));
					if (isset($setting['label']))
						$element->setLabel($setting['label']);
					$element->addMultiOptions($setting['options']);
					if (isset($settings['description']))
						$element->setDescription($setting['description']);
					$this->addElement($element);
					break;
				case 'select':
					$element = $this->createElement('select', $setting['name']);
					if (isset($setting['label']))
						$element->setLabel($setting['label']);
					$element->addMultiOptions($setting['options']);
					if (isset($settings['description']))
						$element->setDescription($setting['description']);
					$this->addElement($element);
					break;
			}
		}

		$this->addElement('submit', 'save', array('label' => $this->_('Save'), 'class' => 'btn btn-primary'));
	}

	/**
	 *
	 * @param type $settings
	 */
	public function fill($settings)
	{
		$app_settings = Msingi_Model_Settings::getInstance();

		foreach ($settings as $setting)
		{
			switch ($setting['type'])
			{
				case 'string':
				case 'radio':
				case 'select':
				case 'text':
					$this->getElement($setting['name'])->setValue($app_settings->get($setting['setting']));
					break;
				case 'checkbox':
					$this->getElement($setting['name'])->setValue($app_settings->getBoolean($setting['setting']));
					break;
				case 'multicheckbox':
					$this->getElement($setting['name'])->setValue($app_settings->getArray($setting['setting']));
					break;
			}
		}
	}

	/**
	 *
	 * @param type $settings
	 * @param type $values
	 */
	public function updateSettings($settings, $values)
	{
		$app_settings = Msingi_Model_Settings::getInstance();

		foreach ($settings as $setting)
		{
			switch ($setting['type'])
			{
				case 'string':
				case 'radio':
				case 'select':
				case 'text':
					$app_settings->set($setting['setting'], $values[$setting['name']]);
					break;
				case 'checkbox':
					$app_settings->set($setting['setting'], $values[$setting['name']] ? true : false);
					break;
				case 'multicheckbox':
					$app_settings->set($setting['setting'], $values[$setting['name']]);
					break;
			}
		}
	}

}