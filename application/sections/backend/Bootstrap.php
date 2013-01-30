<?php

class Backend_Bootstrap extends Msingi_Application_Section_Bootstrap
{

	/**
	 *
	 */
	protected function _initACL()
	{
		$acl = new Zend_Acl();

		$acl->addRole(new Zend_Acl_Role('admin'));
		$acl->addRole(new Zend_Acl_Role('moderator'));

		$acl->addResource(new Zend_Acl_Resource('default.index'));

		// content
		$acl->addResource(new Zend_Acl_Resource('content'));

		$acl->addResource(new Zend_Acl_Resource('news.index'));
		$acl->addResource(new Zend_Acl_Resource('pages.index'));
		$acl->addResource(new Zend_Acl_Resource('images.index'));
		$acl->addResource(new Zend_Acl_Resource('files.index'));

		// appearance
		$acl->addResource(new Zend_Acl_Resource('appearance'));

		$acl->addResource(new Zend_Acl_Resource('menu.index'));
		$acl->addResource(new Zend_Acl_Resource('widgets.index'));
		$acl->addResource(new Zend_Acl_Resource('themes.index'));

		// management
		$acl->addResource(new Zend_Acl_Resource('manage'));

		$acl->addResource(new Zend_Acl_Resource('settings.index'));
		$acl->addResource(new Zend_Acl_Resource('users.index'));
		$acl->addResource(new Zend_Acl_Resource('dictionaries.index'));
		$acl->addResource(new Zend_Acl_Resource('translations.index'));

		// moderator acl
		$acl->allow('moderator', 'default.index');
		$acl->allow('moderator', 'content');

		//
		$acl->allow('admin', null);

		Zend_Registry::set('acl', $acl);
	}

}