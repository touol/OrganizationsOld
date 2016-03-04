<?php

/**
 * Get a list of Kupons
 */
class KuponsGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'OrgsKupons';
	public $classKey = 'OrgsKupons';
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
		/* return ['id','kupon_code', 'type','description', 'org_id', 'shortname', 'user_id', 'username', 'createdby_user_id', 'createdby_user_name', 'createdon', 'date_exp', 'last_used_user_id', 'last_used_user_name', 'add_discount_proc', 'discount_price', 'use_count', 'used_count', 'used', 'actions']; */
		$c->leftJoin('modUser','modUser', '`'.$this->classKey.'`.`user_id` = `modUser`.`id`');
		$c->leftJoin('Orgs','Orgs', '`'.$this->classKey.'`.`org_id` = `Orgs`.`id`');
		$c->leftJoin('modUser','modUser1', '`'.$this->classKey.'`.`createdby_user_id` = `modUser1`.`id`');
		$c->leftJoin('modUser','modUser2', '`'.$this->classKey.'`.`last_used_user_id` = `modUser2`.`id`');
		$Columns = $this->modx->getSelectColumns($this->classKey, $this->classKey, '', '', true);
		
		$c->select($Columns . ', `Orgs`.`shortname` as `shortname`, `modUser`.`username` as `username`, `modUser1`.`username` as `createdby_user_name`, `modUser1`.`username` as `last_used_user_name`');
		if ($query) {
			$c->where(array(
				'`Orgs`.`shortname`:LIKE' => "%{$query}%",
				'OR:`modUser`.`username`:LIKE' => "%{$query}%",
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
		/* $array['actions'][] = array(
			'cls' => '',
			'icon' => 'icon icon-edit',
			'title' => $this->modx->lexicon('organizations_kupon_update'),
			//'multiple' => $this->modx->lexicon('organizations_orgs_update'),
			'action' => 'updateKupon',
			'button' => true,
			'menu' => true,
		); */
		
		// Remove
		$array['actions'][] = array(
			'cls' => '',
			'icon' => 'icon icon-trash-o action-red',
			'title' => $this->modx->lexicon('organizations_kupon_remove'),
			'multiple' => $this->modx->lexicon('organizations_kupons_remove'),
			'action' => 'removeKupon',
			'button' => true,
			'menu' => true,
		);

		return $array;
	}

}

return 'KuponsGetListProcessor';