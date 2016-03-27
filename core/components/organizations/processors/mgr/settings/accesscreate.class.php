<?php

class orgsAccessCreateProcessor extends modObjectProcessor {
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
		//$data = json_decode($data['data'],true);
		unset($data['action']);
		/* unset($data['actions']);
		unset($data['menu']); */
		$c = $this->modx->newQuery($this->classKey);
		$c->where(array(
				'setting' => "org_access",
			));
		
		$conf = $this->modx->getObject($this->classKey, $c);
			if( $conf->xtype == 'array' ){
				$config_value = json_decode( $conf->value, true );
			}
		//$setting = array();
		$id=1;
		foreach($config_value as $value){
			if($value['id'] >=$id){
				$id = $value['id'] + 1;
			}
		}
		$data['id']=$id;
		$config_value[] = $data;
		$conf->value = json_encode($config_value, true);
		if($conf->save()){
			return $this->success('',$data);
		}else{
			return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
		}
		
        
    }
}

return 'orgsAccessCreateProcessor';