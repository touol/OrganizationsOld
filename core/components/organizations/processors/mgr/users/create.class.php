<?php

/**
 * Create an UserLink
 */
class OrganizationsUserLinkCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'OrgsUsersLink';
	public $classKey = 'OrgsUsersLink';
	public $languageTopics = array('organizations');
	public $permission = 'create';


	public function process() {
        /* Run the beforeSet method before setting the fields, and allow stoppage */
        $canSave = $this->beforeSet();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }
		$data = $this->getProperties();
        if($orguser = $this->modx->getObject($this->classKey, array('user_id'=>$data['user_id'],'org_id'=>$data['org_id']))){
			return $this->failure($this->modx->lexicon('organizations_user_add_err'));
		}
		
		if(!$orguser = $this->modx->getObject('OrgsUsers', array('user_id'=>$data['user_id']))){
			$orguser = $this->modx->newObject('OrgsUsers');
		}
		$orguser->fromArray($data);
		if($orguser->save()){
			//return $this->success('',$data);
		}else{
			return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
		}
		
		$this->object->fromArray($data);

        /* run the before save logic */
        $canSave = $this->beforeSave();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }

        /* run object validation */
        if (!$this->object->validate()) {
            /** @var modValidator $validator */
            $validator = $this->object->getValidator();
            if ($validator->hasMessages()) {
                foreach ($validator->getMessages() as $message) {
                    $this->addFieldError($message['field'],$this->modx->lexicon($message['message']));
                }
            }
        }

        $preventSave = $this->fireBeforeSaveEvent();
        if (!empty($preventSave)) {
            return $this->failure($preventSave);
        }

        /* save element */
        if ($this->object->save() == false) {
            $this->modx->error->checkValidation($this->object);
            return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
        }

        $this->afterSave();

        $this->fireAfterSaveEvent();
        $this->logManagerAction();
        return $this->cleanup();
    }
}

return 'OrganizationsUserLinkCreateProcessor';