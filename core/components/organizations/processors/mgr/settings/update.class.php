<?php

class orgsFieldsUpdateProcessor extends modObjectProcessor {
	public $classKey = 'OrgsConfig';
	public $checkSavePermission = true;
	
	public function initialize() {
        if ($this->checkSavePermission && $this->object instanceof modAccessibleObject && !$this->object->checkPolicy('save')) {
            return $this->modx->lexicon('access_denied');
        }

        return parent::initialize();
    }
	/**
     * {@inheritDoc}
     * @return mixed
     */
    public function process() {
        $data = $this->getProperties();
		$data = json_decode($data['data'],true);
        /* if ($this->saveObject() == false) {
            return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
        } */
		unset($data['actions']);
		unset($data['menu']);
		$c = $this->modx->newQuery($this->classKey);
		$c->where(array(
				'setting' => "org_fields",
			));
		
		$conf = $this->modx->getObject($this->classKey, $c);
			if( $conf->xtype == 'array' ){
				$config_value = json_decode( $conf->value, true );
				//$data = array_merge($data, $config_value);
			}
		$setting = array();
		foreach($config_value as $value){
			if($data['id'] == $value['id']){
				$setting[] = $data;
			}else{
				$setting[] = $value;
			}
		}
		$conf->value = json_encode($setting, true);
		if($conf->save()){
			return $this->success('',$data);
		}else{
			return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
		}
		
        
    }
}

return 'orgsFieldsUpdateProcessor';