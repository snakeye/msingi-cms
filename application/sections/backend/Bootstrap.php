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
		//$acl->addRole(new Zend_Acl_Role('moderator'));

		$acl->addResource(new Zend_Acl_Resource('default.index'));

		// resources
//		$acl->addResource(new Zend_Acl_Resource('default.users'));
//		$acl->addResource(new Zend_Acl_Resource('default.parents'));
//		$acl->addResource(new Zend_Acl_Resource('default.providers'));
//		$acl->addResource(new Zend_Acl_Resource('default.jobs'));
//		$acl->addResource(new Zend_Acl_Resource('default.profiles'));
//		$acl->addResource(new Zend_Acl_Resource('default.reviews'));
//
//		$acl->addResource(new Zend_Acl_Resource('default.finance'));
//		$acl->addResource(new Zend_Acl_Resource('default.orders'));
//
//		// content
//		$acl->addResource(new Zend_Acl_Resource('default.content'));
//		$acl->addResource(new Zend_Acl_Resource('default.dictionaries'));
//		$acl->addResource(new Zend_Acl_Resource('default.pages'));
//		$acl->addResource(new Zend_Acl_Resource('default.menu'));
//		$acl->addResource(new Zend_Acl_Resource('default.mailtemplates'));
//		$acl->addResource(new Zend_Acl_Resource('default.banners'));
//		$acl->addResource(new Zend_Acl_Resource('default.widgets'));
//		$acl->addResource(new Zend_Acl_Resource('default.slider'));
//		$acl->addResource(new Zend_Acl_Resource('default.images'));
//
//		$acl->addResource(new Zend_Acl_Resource('default.manage'));
//		$acl->addResource(new Zend_Acl_Resource('default.admins'));
//		$acl->addResource(new Zend_Acl_Resource('default.settings'));
//		$acl->addResource(new Zend_Acl_Resource('default.memberships'));
//		$acl->addResource(new Zend_Acl_Resource('default.reports'));
//		$acl->addResource(new Zend_Acl_Resource('default.invites'));
//		$acl->allow('moderator', 'admin.index');

		$acl->allow('admin', null);

		Zend_Registry::set('acl', $acl);
	}

}