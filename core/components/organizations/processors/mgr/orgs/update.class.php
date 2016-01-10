<?php

/**
 * Update an Org
 */
class OrganizationsOrgUpdateProcessor extends modObjectUpdateProcessor {
	public $objectType = 'Orgs';
	public $classKey = 'Orgs';
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


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$id = (int)$this->getProperty('id');
		$name = trim($this->getProperty('shortname'));
		if (empty($id)) {
			return $this->modx->lexicon('organizations_item_err_ns');
		}

		if (empty($name)) {
			$this->modx->error->addField('shortname', $this->modx->lexicon('organizations_item_err_name'));
		}
		elseif ($this->modx->getCount($this->classKey, array('name' => $name, 'id:!=' => $id))) {
			$this->modx->error->addField('shortname', $this->modx->lexicon('organizations_item_err_ae'));
		}

		return parent::beforeSet();
	}
	 /**
     * {@inheritDoc}
     * @return mixed
     */
    public function process() {
        /* Run the beforeSet method before setting the fields, and allow stoppage */
        $canSave = $this->beforeSet();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }
		$data = $this->getProperties();
		$data['inn'] = intval($data['inn']);
		$data['ogrn'] = intval($data['ogrn']);
		$data['okpo'] = intval($data['okpo']);
        $this->object->fromArray($data);

        /* Run the beforeSave method and allow stoppage */
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
		
        /* run the before save event and allow stoppage */
        $preventSave = $this->fireBeforeSaveEvent();
        if (!empty($preventSave)) {
            return $this->failure($preventSave);
        }

        if ($this->saveObject() == false) {
            return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
        }
        $this->afterSave();
        $this->fireAfterSaveEvent();
        $this->logManagerAction();
        return $this->cleanup();
    }
}

return 'OrganizationsOrgUpdateProcessor';
