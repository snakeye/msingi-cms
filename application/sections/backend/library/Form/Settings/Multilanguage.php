<?php

class Form_Settings_Multilanguage extends Msingi_Form_Tabs
{

	/**
	 *
	 */
	public function init()
	{
		$this->setAction('/settings');
		$this->setMethod('post');

		$this->addElement('hidden', 'group');
	}

	/**
	 *
	 * @param type $settings
	 */
	public function createElements($settings)
	{
		$languages = new Msingi_Model_Constants_Languages();

		$sections = Zend_Registry::get('Sections');

		foreach ($sections->sections() as $section)
		{
			$elements = array();

			//
			$type = $this->createElement('radio', 'type_' . $section->name(), array(
				'label' => $this->_('Multilanguage support'),
				'label_class' => 'radio',
				'separator' => ' ',
				));

			$type->addMultiOptions(array(
				'single' => $this->_('Single language'),
				'multiple' => $this->_('Multi language'),
			));

			$elements[] = $type;

			$default = $this->createElement('select', 'default_' . $section->name(), array(
				'label' => $this->_('Default language'),
				));

			$default->addMultiOptions($languages->getPairs(false, Msingi_Model_Constants_Languages::LABEL_LONG));

			$elements[] = $default;

			$enabled = $this->createElement('multiCheckbox', 'enabled_' . $section->name(), array(
				'label' => $this->_('Enabled languages'),
				'label_class' => 'checkbox multicheckbox',
				'separator' => ' ',
				));

			$enabled->addMultiOptions($languages->getPairs(false, Msingi_Model_Constants_Languages::LABEL_LONG));

			$elements[] = $enabled;


			//
			$this->addDisplayGroup($elements, 'section_' . $section->name(), array(
				'legend' => $section->name(),
			));
		}

		// submit button
		$submit = $this->createElement('submit', 'submit', array(
			'required' => false,
			'ignore' => true,
			'label' => $this->_('Save'),
			'class' => 'btn btn-primary',
			));

		$this->addElement($submit);

		$this->loadDefaultDecorators();
	}

	/**
	 *
	 * @param type $settings
	 */
	public function fill($settings)
	{
		$app_settings = Msingi_Model_Settings::getInstance();

		$sections = Zend_Registry::get('Sections');

		foreach ($sections->sections() as $section)
		{
			$this->getElement('type_' . $section->name())->setValue($app_settings->get('section:' . $section->name() . ':languages:type', 'single'));
			$this->getElement('default_' . $section->name())->setValue($app_settings->get('section:' . $section->name() . ':languages:default', 'en'));
			$this->getElement('enabled_' . $section->name())->setValue($app_settings->getArray('section:' . $section->name() . ':languages:enabled', 'en'));
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

		$sections = Zend_Registry::get('Sections');

		foreach ($sections->sections() as $section)
		{
			$type = $values['type_' . $section->name()];
			$default = $values['default_' . $section->name()];

			if ($type == 'single')
			{
				$enabled = array($default);
			}
			else
			{
				$enabled = $values['enabled_' . $section->name()];

				if (!in_array($default, $enabled))
				{
					$enabled[] = $default;
				}
			}

			$app_settings->set('section:' . $section->name() . ':languages:type', $type);
			$app_settings->set('section:' . $section->name() . ':languages:default', $default);
			$app_settings->set('section:' . $section->name() . ':languages:enabled', $enabled);
		}
	}

}