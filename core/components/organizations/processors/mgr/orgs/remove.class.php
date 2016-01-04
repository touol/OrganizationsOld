<?php

/**
 * Remove an Orgs
 */
class OrganizationsOrgRemoveProcessor extends modObjectProcessor {
	public $objectType = 'Orgs';
	public $classKey = 'Orgs';
	public $languageTopics = array('organizations');
	public $permission = 'remove';


	/**
	 * @return array|string
	 */
	public function process() {
		if (!$this->checkPermissions()) {
			return $this->failure($this->modx->lexicon('access_denied'));
		}

		$ids = $this->modx->fromJSON($this->getProperty('ids'));
		if (empty($ids)) {
			return $this->failure($this->modx->lexicon('organizations_item_err_ns'));
		}

		foreach ($ids as $id) {
			/** @var OrganizationsOrg $object */
			if (!$object = $this->modx->getObject($this->classKey, $id)) {
				return $this->failure($this->modx->lexicon('organizations_item_err_nf'));
			}

			$object->remove();
		}

		return $this->success();
	}

}

return 'OrganizationsOrgRemoveProcessor';