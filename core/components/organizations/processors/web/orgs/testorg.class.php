<?php

/**
 * Test an Org
 */
class TestOrgProcessor extends modProcessor {
	public $objectType = 'Orgs';
	public $classKey = 'Orgs';
	public $languageTopics = array('organizations:default');
	public $permission = 'view';


	/**
	 * We doing special check of permission
	 * because of our objects is not an instances of modAccessibleObject
	 *
	 * @return mixed
	 */
	public function process() {
		if (!$this->checkPermissions()) {
			return $this->failure($this->modx->lexicon('access_denied'));
		}

		$c = $this->modx->newQuery($this->classKey);
		$c->where(array(
				'shortname' => $this->getProperty('shortname'),
				'inn' => $this->getProperty('inn'),
			));
		
		$org = $this->modx->getObject($this->classKey, $c);
		if($org){
			return $this->success('',array(
				'shortname' => $this->getProperty('shortname'),
				'inn' => $this->getProperty('inn'),
			));
		}else{
			return $this->failure('',array(
				'shortname' => $this->getProperty('shortname'),
				'inn' => $this->getProperty('inn'),
			));
		}
	}

}

return 'TestOrgProcessor';