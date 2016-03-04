<?php

/**
 * Get a list of Invites
 */
class InvitesGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'OrgsInvites';
	public $classKey = 'OrgsInvites';
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
		/* return ['id','invite_code', 'type','description', 'org_id', 'shortname', 'user_group_id', 'user_group_name','email','email_sended','fullname','kupon_id', 'kupon_code','createdby_user_id', 'createdby_user_name', 'createdon', 'date_exp', 'used_user_id', 'used_user_name', 'used', 'actions']; */
		//$c->leftJoin('modUser','modUser', '`'.$this->classKey.'`.`user_id` = `modUser`.`id`');
		$c->leftJoin('Orgs','Orgs', '`'.$this->classKey.'`.`org_id` = `Orgs`.`id`');
		$c->leftJoin('modUser','modUser1', '`'.$this->classKey.'`.`createdby_user_id` = `modUser1`.`id`');
		$c->leftJoin('modUser','modUser2', '`'.$this->classKey.'`.`used_user_id` = `modUser2`.`id`');
		$c->leftJoin('OrgsKupons','OrgsKupons', '`'.$this->classKey.'`.`kupon_id` = `OrgsKupons`.`id`');
		$Columns = $this->modx->getSelectColumns($this->classKey, $this->classKey, '', '', true);
		
		$c->select($Columns . ', `Orgs`.`shortname` as `shortname`, `modUser1`.`username` as `createdby_user_name`, `modUser1`.`username` as `used_user_name`, `OrgsKupons`.`kupon_code` as `kupon_code`');
		if ($query) {
			$c->where(array(
				'`Orgs`.`shortname`:LIKE' => "%{$query}%",
				'OR:`modUser1`.`username`:LIKE' => "%{$query}%",
				'OR:`modUser2`.`username`:LIKE' => "%{$query}%",
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
		$array['actions'][] = array(
			'cls' => '',
			'icon' => 'icon icon-envelope',
			'title' => $this->modx->lexicon('organizations_invite_send'),
			//'multiple' => $this->modx->lexicon('organizations_orgs_update'),
			'action' => 'sendInvite',
			'button' => true,
			'menu' => true,
		);
		
		// Remove
		$array['actions'][] = array(
			'cls' => '',
			'icon' => 'icon icon-trash-o action-red',
			'title' => $this->modx->lexicon('organizations_invite_remove'),
			'multiple' => $this->modx->lexicon('organizations_invites_remove'),
			'action' => 'removeInvite',
			'button' => true,
			'menu' => true,
		);

		return $array;
	}

}

return 'InvitesGetListProcessor';