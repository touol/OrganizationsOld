<?php

/**
 * Update an OrgsUsersLink
 */
class OrganizationsOrgsUsersLinkUpdateProcessor extends modProcessor {
	public $objectType = 'OrgsUsersLink';
	public $classKey = 'OrgsUsersLink';
	public $languageTopics = array('organizations');
	public $permission = 'save';


	/**
	 * We doing special check of permission
	 * because of our objects is not an instances of modAccessibleObject
	 *
	 * @return bool|string
	 */
	public function beforeSave() {
		if (!$this->checkPermissions()) {
			return $this->modx->lexicon('access_denied');
		}

		return true;
	}

	public function process() {
        $data = $this->getProperties();
		$data = json_decode($data['data'],true);
		unset($data['actions']);
		unset($data['menu']);
		$conf = $this->modx->getObject($this->classKey, $data['id']);
		$conf->fromArray($data);
		if($conf->save()){
			return $this->success('',$data);
		}else{
			return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
		}
    }
}

return 'OrganizationsOrgsUsersLinkUpdateProcessor';
