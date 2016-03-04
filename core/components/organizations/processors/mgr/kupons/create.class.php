<?php

/**
 * Create an Kupon
 */
class OrganizationsKuponCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'OrgsKupons';
	public $classKey = 'OrgsKupons';
	public $languageTopics = array('organizations');
	public $permission = 'create';


	/**
	 * @return bool
	 */
	public function process() {
        /* Run the beforeSet method before setting the fields, and allow stoppage */
        $canSave = $this->beforeSet();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }
		$data = $this->getProperties();
		if (!$Orgs = $this->modx->getService('organizations', 'Organizations',$this->modx->getOption('organizations_core_path', null, $this->modx->getOption('core_path') . 'components/organizations/') . 'model/organizations/', array())) {
			return $this->failure($this->modx->lexicon($this->objectType.'_Could not load Organizations class!'));
		}
		//strftime('%Y-%m-%d %H:%M:%S',$timestamp);date("Y-m-d H:i:s")
		
		$data['createdon']= strftime('%Y-%m-%d %H:%M:%S',strtotime("now"));
		switch($data['type']){
			case 1:
				$data['kupon_code'] = $Orgs->generate(6, 'KO1-');
			break;
			case 2:
				$data['kupon_code'] = $Orgs->generate(6, 'KO2-');
				if($data['period']!=''){
					$data['date_exp']= strftime('%Y-%m-%d %H:%M:%S',strtotime('now +'.$data['period'].' month'));
				}
			break;
			default:
				$data['kupon_code'] = $Orgs->generate(6, 'KDA-');
				if($data['period']!=''){
					$data['date_exp']= strftime('%Y-%m-%d %H:%M:%S',strtotime('now +'.$data['period'].' month'));
				}
			break;
		}
		$data['createdby_user_id']=$this->modx->user->get('id');
		
		
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
		/* //email
		if($data['send_email']){
			$invite_email_tpl = $this->modx->getOption('invite_email_tpl', null, 'invite_email_tpl');
			$invite_email_subject = $this->modx->getOption('invite_email_subject', null, 'Приглашение на сайт!');
			$body = $this->modx->getChunk($invite_email_tpl, $data);
			$this->object->email_sended = $Orgs->sendEmail($data['email'], $invite_email_subject, $body);
			if ($this->object->save() == false) {
				$this->modx->error->checkValidation($this->object);
				return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
			}
		} */
        $this->fireAfterSaveEvent();
        $this->logManagerAction();
        return $this->cleanup();
    }
	
}

return 'OrganizationsKuponCreateProcessor';