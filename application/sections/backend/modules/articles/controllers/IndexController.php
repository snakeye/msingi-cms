<?php

class Articles_IndexController extends Msingi_Controller_Backend_ListingAbstract
{

	protected function getEditForm()
	{
		$form = new Form_Article();

		return $form;
	}

	protected function onNewRow($form)
	{
		$form->createControls();

		$form->getElement('date')->setValue(date('Y-m-d H:i:s'));
		$form->getElement('status')->setValue(Cms_Article::STATUS_DRAFT);
	}

	protected function onEditRow($form)
	{
		$form->createControls();
	}

	protected function updateRow($article, $values, $form)
	{
		parent::updateRow($article, $values, $form);

		$languages = Msingi_Model_Settings::getInstance()->getArray('section:frontend:languages:enabled');

		foreach ($languages as $lang)
		{
			$article_texts = $article->getTexts($lang, true, false);

			$article_texts->title = $values['title_' . $lang];
			$article_texts->content = $values['content_' . $lang];
			$article_texts->meta_keywords = $values['meta_keywords_' . $lang];
			$article_texts->meta_description = $values['meta_description_' . $lang];

			$article_texts->save();
		}
	}

	protected function onPopulate($form, $row)
	{
		$form->fillValues($row);
	}

	protected function getFilter()
	{

	}

	protected function getPaginatorQuery($request, $filter)
	{
		$table = $this->getTable();

		return $table->select()->order('date DESC');
	}

	protected function getTable()
	{
		return Cms_Articles::getInstance();
	}

}