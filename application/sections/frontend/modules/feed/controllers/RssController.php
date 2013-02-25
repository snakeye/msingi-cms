<?php

/**
 * Blog/news RSS controller
 *
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Feed_RssController extends Msingi_Controller
{

	/**
	 * Index action
	 */
	public function indexAction()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();

		$this->getResponse()->setHeader('Content-Type', 'text/xml; charset=UTF-8');

		// Set feed values
		$array['title'] = $this->_('News');
		$array['link'] = 'http://' . $_SERVER['HTTP_HOST'] . '/feed/news';
		$array['description'] = $this->_('News RSS feed');
		$array['charset'] = 'utf-8';

		$lastUpdated = 0;
		$language = $this->language();
		$root = $this->view->root();

		// Loop through db records and add feed items to array
		$items = Cms_Articles::getInstance()->fetchRecent(10);
		foreach ($items as $item)
		{
			$texts = $item->getTexts($language);

			$updated = strtotime($item->date);
			$array['entries'][] = array(
				'title' => $texts->title == '' ? $this->_('No title') : $texts->title,
				'link' => $root . '/news/article' . $item->id,
				'guid' => $root . '/news/article' . $item->id,
				'lastUpdate' => $updated,
				'description' => $texts->content,
			);

			if ($updated > $lastUpdated)
				$lastUpdated = $updated;
		}

		$array['lastUpdate'] = $lastUpdated;

		// Import rss feed from array
		$feed = Zend_Feed::importArray($array, 'rss');

		// Send http headers and dump the feed
		$feed->send();
	}

}