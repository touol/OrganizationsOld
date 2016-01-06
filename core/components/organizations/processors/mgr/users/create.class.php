<?php

/**
 * Create an UserLink
 */
class OrganizationsUserLinkCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'OrgsUsersLink';
	public $classKey = 'OrgsUsersLink';
	public $languageTopics = array('organizations');
	public $permission = 'create';


	/**
	 * @return bool
	 */
}

return 'OrganizationsUserLinkCreateProcessor';