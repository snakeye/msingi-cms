<?php

class Form_Article extends Msingi_Form_Tabs
{

	/**
	 *
	 */
	public function init()
	{
		$this->setAction('/articles/index/edit');
		$this->setMethod('post');

		$this->addElement('hidden', 'id');
	}

	/**
	 *
	 * @param type $page
	 */
	public function createControls()
	{
		$languages = Msingi_Model_Settings::getInstance()->getArray('section:frontend:languages:enabled');

		foreach ($languages as $lang)
		{
			$elements = array();

			$title = $this->createElement('text', 'title_' . $lang, array(
				'label' => $this->_('Title'),
				'class' => 'span12',
				'filters' => array('StringTrim', 'StripTags'),
					));

			$elements[] = $title;

			$content = $this->createElement('textarea', 'content_' . $lang, array(
				'label' => $this->_('Content'),
				'rows' => 10,
				'class' => 'wysiwyg',
				'filters' => array('StringTrim', new Form_Filter_PageTags()),
					));

			$elements[] = $content;

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
		$date = $this->createElement('text', 'date', array(
			'label' => $this->_('Date'),
			'filters' => array('StringTrim', 'StripTags'),
				));

		$status = $this->createElement('select', 'status', array(
			'label' => $this->_('Status'),
			'filters' => array('StringTrim', 'StripTags'),
			'multiOptions' => array(
				Cms_Article::STATUS_DRAFT => $this->_('Draft'),
				Cms_Article::STATUS_PUBLISHED => $this->_('Published'),
			),
				)
		);

		$slug = $this->createElement('text', 'slug', array(
			'label' => $this->_('Slug'),
			'filters' => array('StringTrim', 'StripTags'),
				));

		$this->addDisplayGroup(array($date, $status, $slug), 'common', array(
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
	public function fillValues($article)
	{
		$languages = Msingi_Model_Settings::getInstance()->getArray('section:frontend:languages:enabled');

		$this->populate($article->toArray());
		
		foreach ($languages as $lang)
		{
			$article_texts = $article->getTexts($lang, true);

			$this->getElement('title_' . $lang)->setValue($article_texts->title);
			$this->getElement('content_' . $lang)->setValue($article_texts->content);
			$this->getElement('meta_keywords_' . $lang)->setValue($article_texts->meta_keywords);
			$this->getElement('meta_description_' . $lang)->setValue($article_texts->meta_description);
		}
	}

}