<?php

/**
 * Create an Org
 */
class OrganizationsOrgCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'Orgs';
	public $classKey = 'Orgs';
	public $languageTopics = array('organizations');
	public $permission = 'create';


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$name = trim($this->getProperty('shortname'));
		if (empty($name)) {
			$this->modx->error->addField('shortname', $this->modx->lexicon('organizations_item_err_name'));
		}
		elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
			$this->modx->error->addField('shortname', $this->modx->lexicon('organizations_item_err_ae'));
		}

		return parent::beforeSet();
	}

}

return 'OrganizationsOrgCreateProcessor';