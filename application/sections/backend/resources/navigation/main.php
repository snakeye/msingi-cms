
<?php

$menu = array();

$menu[] = array(
	'label' => $this->_('Dashboard'),
	'module' => 'default',
	'controller' => 'index',
	'action' => 'index',
	'resource' => 'default.index',
);

//
$menu[] = array(
	'label' => $this->_('Content'),
	'uri' => '#',
	'resource' => 'content',
	'icon' => 'icon-folder-close',
	'pages' => array(
		array(
			'label' => $this->_('Blog/news'),
			'module' => 'news',
			'controller' => 'index',
			'action' => 'index',
			'resource' => 'news.index',
		),
		array(
			'label' => $this->_('Pages'),
			'module' => 'pages',
			'controller' => 'index',
			'action' => 'index',
			'resource' => 'pages.index',
		),
		array(
			'label' => $this->_('Photo gallery'),
			'module' => 'images',
			'controller' => 'index',
			'action' => 'index',
			'resource' => 'images.index',
			'pages' => array(
				array(
					'visible' => false,
					'module' => 'images',
					'controller' => 'index',
					'action' => 'view',
					'resource' => 'images.index',
				),
			),
		),
		array(
			'label' => $this->_('Files'),
			'module' => 'files',
			'controller' => 'index',
			'action' => 'index',
			'resource' => 'files.index',
		),
	),
);

$menu[] = array(
	'label' => $this->_('Appearance'),
	'uri' => '#',
	'resource' => 'appearance',
	'icon' => 'icon-adjust',
	'pages' => array(
		array(
			'label' => $this->_('Menu'),
			'module' => 'menu',
			'controller' => 'index',
			'action' => 'index',
			'resource' => 'menu.index',
		),
		array(
			'label' => $this->_('Widgets'),
			'module' => 'widgets',
			'controller' => 'index',
			'action' => 'index',
			'resource' => 'widgets.index',
		),
		array(
			'label' => $this->_('Themes'),
			'module' => 'themes',
			'controller' => 'index',
			'action' => 'index',
			'resource' => 'themes.index',
		),
	),
);

$menu[] = array(
	'label' => $this->_('Manage'),
	'uri' => '#',
	'resource' => 'manage',
	'icon' => 'icon-cog',
	'pages' => array(
		array(
			'label' => $this->_('Settings'),
			'module' => 'settings',
			'controller' => 'index',
			'action' => 'index',
			'resource' => 'settings.index',
		),
		array(
			'label' => $this->_('Users'),
			'module' => 'users',
			'controller' => 'index',
			'action' => 'index',
			'resource' => 'users.index',
		),
		array(
			'label' => $this->_('Dictionaries'),
			'module' => 'dictionaries',
			'controller' => 'index',
			'action' => 'index',
			'resource' => 'dictionaries.index',
		),
		array(
			'label' => $this->_('Translations'),
			'module' => 'translations',
			'controller' => 'index',
			'action' => 'index',
			'resource' => 'translations.index',
		),
	),
);

return $menu;
