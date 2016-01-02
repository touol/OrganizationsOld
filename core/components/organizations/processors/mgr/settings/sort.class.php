<?php

// It is adapted code from https://github.com/splittingred/Gallery/blob/a51442648fde1066cf04d46550a04265b1ad67da/core/components/gallery/processors/mgr/item/sort.php

class orgsSortProcessor extends modObjectProcessor {
	public $classKey = 'OrgsConfig';



	/** {@inheritDoc} */
	public function initialize() {
		/* if (!$this->modx->hasPermission($this->permission)) {
			return $this->modx->lexicon('access_denied');
		} */
		return parent::initialize();
	}


	/** {@inheritDoc} */
	public function process() {
		/* @var msPayment $source */
		//$source = $this->modx->getObject($this->classKey, $this->getProperty('source'));
		/* @var msPayment $target */
		//$target = $this->modx->getObject($this->classKey, $this->getProperty('target'));
		$c = $this->modx->newQuery($this->classKey);
		$c->where(array(
				'setting' => "org_fields",
			));
		
		$conf = $this->modx->getObject($this->classKey, $c);
			if( $conf->xtype == 'array' ){
				$config_value = json_decode( $conf->value, true );
			}
		$sort = array();
		foreach($config_value as $value){
			if($value['id'] == $this->getProperty('source')){
				$source_rank = $value['rank'];
			}elseif($value['id'] == $this->getProperty('target')){
				$target_rank = $value['rank'];
			}
		}
		foreach($config_value as $value){
			if($value['id'] == $this->getProperty('source')){
				$value['rank'] = $target_rank;
			}elseif($value['id'] == $this->getProperty('target')){
				$value['rank'] = $source_rank;
			}
			$sort[] = $value;
		}
		uasort($sort, 'myCmp');
		$conf->value = json_encode($sort, true);
		if($conf->save()){
			return $this->success('',$sort);
		}else{
			return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
		}
	}
}
function myCmp($a, $b) {
	if ($a['rank'] === $b['rank']) return 0;
	return $a['rank'] > $b['rank'] ? 1 : -1;
}

return 'orgsSortProcessor';