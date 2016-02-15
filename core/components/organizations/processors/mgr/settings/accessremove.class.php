<?php

class orgsAccessRemoveProcessor extends modObjectProcessor {
	public $classKey = 'OrgsConfig';
	
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
        $ids = $this->modx->fromJSON($this->getProperty('ids'));
		$c = $this->modx->newQuery($this->classKey);
		$c->where(array(
				'setting' => "org_access",
			));
		
		$conf = $this->modx->getObject($this->classKey, $c);
			if( $conf->xtype == 'array' ){
				$config_value = json_decode( $conf->value, true );
			}
		$setting = array();
		foreach($config_value as $value){
			if(in_array($value['id'], $ids)){
				//$setting[] = $data;
			}else{
				$setting[] = $value;
			}
		}
		//$config_value[] = $data;
		$conf->value = json_encode($setting, true);
		if($conf->save()){
			return $this->success('',$data);
		}else{
			return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
		}
		
        
    }
}

return 'orgsAccessRemoveProcessor';