<?php

/**
 * Update an OrgsUsersLink
 */
class OrganizationsOrgsUsersLinkUpdateProcessor extends modProcessor {
	public $objectType = 'OrgsUsersLink';
	public $classKey = 'OrgsUsersLink';
	public $languageTopics = array('organizations');
	//public $permission = 'save';


	/**
	 * We doing special check of permission
	 * because of our objects is not an instances of modAccessibleObject
	 *
	 * @return bool|string
	 */
	//public function beforeSave() {
	//	if (!$this->checkPermissions()) {
	//		return $this->modx->lexicon('access_denied');
	//	}
//
//		return true;
//	}

	public function process() {
        $data = $this->getProperties();
		//$data = json_decode($data['data'],true);
		unset($data['actions']);
		unset($data['menu']);
		
		if(!$orguser = $this->modx->getObject('OrgsUsers', array('user_id'=>$data['user_id']))){
		    $orguser = $this->modx->newObject('OrgsUsers');
		}
		$orguser->fromArray(array(
						'user_id'=>$data['user_id']));
		if($orguser->save()){
			//return $this->success('',$data);
		}else{
			return $this->failure($this->modx->lexicon($this->objectType.'orguser_err_save'));
		}
		
		
		
		if($orguserlink = $this->modx->getObject($this->classKey, $data['id'])){
		   $orguserlink->fromArray($data);
    		if($orguserlink->save()){
    			return $this->success('',$data);
    		}else{
    			return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
    		} 
		}else{
		    return $this->failure($this->modx->lexicon($this->objectType.'_orguserlink_err_save'));
		}
		
		
    }
}

return 'OrganizationsOrgsUsersLinkUpdateProcessor';