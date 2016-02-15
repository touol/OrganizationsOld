<?php

/**
 * Get a list of Setting
 */
class OrganizationsSettingGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'OrgsConfig';
	public $classKey = 'OrgsConfig';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'DESC';
	//public $permission = 'list';


	/**
	 * * We doing special check of permission
	 * because of our objects is not an instances of modAccessibleObject
	 *
	 * @return boolean|string
	 */
	public function beforeQuery() {
		if (!$this->checkPermissions()) {
			return $this->modx->lexicon('access_denied');
		}

		return true;
	}

	public function process() {
        $beforeQuery = $this->beforeQuery();
        if ($beforeQuery !== true) {
            return $this->failure($beforeQuery);
        }
		$setting = trim($this->getProperty('setting'));
		$group_data = trim($this->getProperty('group_data'));
		if($group_data){
			$group_access = json_decode( $group_data, true );
		}
		$c = $this->modx->newQuery($this->classKey);
		$c->where(array(
				'setting' => $setting,
			));
		
		$conf = $this->modx->getObject($this->classKey, $c);
			if( $conf->xtype == 'array' ){
				$config_value = json_decode( $conf->value, true );
			}
		$list = array();
		$count = 0;
		foreach($config_value as $array){
			if($setting =="org_access"){
				if($group_data){
					if(isset($group_access[$array['name']]) and $group_access[$array['name']]){
						$array['enabled'] = true;
					}else{
						$array['enabled'] = false;
					}
				}
				$array['actions'] = array();
				// Edit
				$array['actions'][] = array(
					'cls' => '',
					'icon' => 'icon icon-edit',
					'title' => $this->modx->lexicon('organizations_access_update'),
					'action' => 'updateAccess',
					'button' => true,
					'menu' => true,
				);
				// Remove
				$array['actions'][] = array(
					'cls' => '',
					'icon' => 'icon icon-trash-o action-red',
					'title' => $this->modx->lexicon('organizations_access_remove'),
					'multiple' => $this->modx->lexicon('organizations_accesss_remove'),
					'action' => 'removeAccess',
					'button' => true,
					'menu' => true,
				);
			}
			$list[] = $array;
			$count++;
		}
        return $this->outputArray($list, $count);
    }

}

return 'OrganizationsSettingGetListProcessor';