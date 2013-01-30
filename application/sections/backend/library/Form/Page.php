<?php

class Form_Page extends Msingi_Form_Tabs
{

	/**
	 *
	 */
	public function init()
	{
		$this->setAction('/pages/save');
		$this->setMethod('post');

		$this->addElement('hidden', 'id');
	}

	/**
	 *
	 * @param type $page
	 */
	public function createControls($page)
	{
		//$languages = Msingi_Model_Settings::getInstance()->getArray('multilanguage:languages');
		$languages = Msingi_Model_Settings::getInstance()->getArray('section:frontend:languages:enabled');

		$template = $page->template();

		foreach ($languages as $lang)
		{
			$elements = array();

			$title = $this->createElement('text', 'title_' . $lang, array(
				'label' => $this->_('Title'),
				'class' => 'span12',
				'filters' => array('StringTrim', 'StripTags'),
				));

			$elements[] = $title;

			// if template is defined
			if ($template != null)
			{
				foreach ($template->sections() as $section)
				{
					$content = $this->createElement('textarea', 'section_' . $this->filter_section_name($section) . '_' . $lang, array(
						'label' => $this->_('Content section') . ': ' . $section,
						'rows' => 10,
						'class' => 'wysiwyg',
						'filters' => array('StringTrim', new Form_Filter_PageTags()),
						));

					$elements[] = $content;
				}
			}

			$meta_keywords = $this->createElement('text', 'meta_keywords_' . $lang, array(
				'label' => $this->_('Meta keywords'),
				'class' => 'span12',
				'filters' => array('StringTrim', 'StripTags'),
				));

			$elements[] = $meta_keywords;

			$meta_description = $this->createElement('text', 'meta_description_' . $lang, array(
				'label' => $this->_('Meta description'),
				'class' => 'span12',
				'filters' => array('StringTrim', 'StripTags'),
				));

			$elements[] = $meta_description;

			//
			$this->addDisplayGroup($elements, 'language_' . $lang, array(
				'legend' => $lang,
			));
		}

		// Common page properties
		$path = $this->createElement('text', 'path', array(
			'label' => $this->_('Path'),
			'filters' => array('StringTrim', 'StripTags'),
			));

		$template_id = $this->createElement('select', 'template_id', array(
			'label' => $this->_('Template'),
			));

		$page_templates = new Msingi_Model_Pages_TemplatesTable();
		$template_id->addMultiOptions(array(null => ''));
		$template_id->addMultiOptions($page_templates->fetchPairs());

		if ($page->type == Msingi_Model_Pages_Page::TYPE_REQUEST)
		{
			$path->setAttrib('readonly', 'readonly');
			$template_id->setAttrib('readonly', 'readonly');
		}

		$this->addDisplayGroup(array($path, $template_id), 'common', array(
			'legend' => $this->_('Common'),
		));

		// submit button
		$submit = $this->createElement('submit', 'submit', array(
			'label' => $this->_('Save'),
			'class' => 'btn btn-primary',
			));

		$this->addElement($submit);

		$this->loadDefaultDecorators();
	}

	/**
	 *
	 * @param type $page
	 */
	public function fillValues($page)
	{
		$languages = Msingi_Model_Settings::getInstance()->getArray('section:frontend:languages:enabled');

		$template = $page->template();

		$this->getElement('id')->setValue($page->id);
		$this->getElement('path')->setValue($page->path);
		$this->getElement('template_id')->setValue($page->template_id);

		foreach ($languages as $lang)
		{
			$page_texts = $page->getTexts($lang, true);

			$this->getElement('title_' . $lang)->setValue($page_texts->title);
			$this->getElement('meta_keywords_' . $lang)->setValue($page_texts->meta_keywords);
			$this->getElement('meta_description_' . $lang)->setValue($page_texts->meta_description);

			if ($template != null)
			{
				foreach ($template->sections() as $section)
				{
					$page_section = $page->section($section, true);

					$page_section_texts = $page_section->getTexts($lang, true);

					$this->getElement('section_' . $this->filter_section_name($section) . '_' . $lang)->setValue($page_section_texts->content);
				}
			}
		}
	}

	/**
	 *
	 * @param type $section
	 * @return type
	 */
	protected function filter_section_name($section)
	{
		$section = preg_replace('/[^a-zA-Z0-9-_]/', '', $section);
		$section = preg_replace('/[-]+/', '_', $section);

		return $section;
	}

}