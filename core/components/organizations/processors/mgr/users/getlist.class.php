<?php

/**
 * Get a list of Users
 */
class UsersGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'OrgsUsersLink';
	public $classKey = 'OrgsUsersLink';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'ASC';
	//public $permission = 'list';


	/**
	 * * We doing special check of permission
	 * because of our objects is not an instances of modAccessibleObject
	 *
	 * @return boolean|string
	 */
	public function beforeQuery() {
		if (!$this->checkPermissions()) {
			return $this->modx->lexicon('access_denied');
		}
		return true;
	}


	/**
	 * @param xPDOQuery $c
	 *
	 * @return xPDOQuery
	 */
	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$query = trim($this->getProperty('query'));
		$org_id = trim($this->getProperty('org_id'));
		$c->leftJoin('modUser','modUser', '`'.$this->classKey.'`.`user_id` = `modUser`.`id`');
		$c->leftJoin('Orgs','Orgs', '`'.$this->classKey.'`.`org_id` = `Orgs`.`id`');
		$orderColumns = $this->modx->getSelectColumns($this->classKey, $this->classKey, '', '', true);
		$c->select($orderColumns . ', `modUser`.`username` as `username`, `Orgs`.`shortname` as `shortname`');
		if ($query) {
			$c->where(array(
				'name:LIKE' => "%{$query}%",
				'OR:description:LIKE' => "%{$query}%",
			));
		}
		if ($org_id) {
			$c->where(array(
				'`Orgs`.`id`:LIKE' => "%{$org_id}%",
			));
		}

		return $c;
	}


	/**
	 * @param xPDOObject $object
	 *
	 * @return array
	 */
	public function prepareRow(xPDOObject $object) {
		$array = $object->toArray();
		$array['actions'] = array();

		// Edit
		/* $array['actions'][] = array(
			'cls' => '',
			'icon' => 'icon icon-edit',
			'title' => $this->modx->lexicon('organizations_user_update'),
			//'multiple' => $this->modx->lexicon('organizations_orgs_update'),
			'action' => 'updateUser',
			'button' => true,
			'menu' => true,
		); */
		
		if (!$array['active']) {
			$array['actions'][] = array(
				'cls' => '',
				'icon' => 'icon icon-power-off action-green',
				'title' => $this->modx->lexicon('organizations_user_enable'),
				'multiple' => $this->modx->lexicon('organizations_users_enable'),
				'action' => 'enableUser',
				'button' => true,
				'menu' => true,
			);
		}
		
		else {
			$array['actions'][] = array(
				'cls' => '',
				'icon' => 'icon icon-power-off action-gray',
				'title' => $this->modx->lexicon('organizations_user_disable'),
				'multiple' => $this->modx->lexicon('organizations_users_disable'),
				'action' => 'disableUser',
				'button' => true,
				'menu' => true,
			);
		}

		// Remove
		$array['actions'][] = array(
			'cls' => '',
			'icon' => 'icon icon-trash-o action-red',
			'title' => $this->modx->lexicon('organizations_user_remove'),
			'multiple' => $this->modx->lexicon('organizations_users_remove'),
			'action' => 'removeUser',
			'button' => true,
			'menu' => true,
		);

		return $array;
	}

}

return 'UsersGetListProcessor';