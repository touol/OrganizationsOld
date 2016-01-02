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
        //$data = $this->getData();
        //$list = $this->iterate($data);
		$c = $this->modx->newQuery($this->classKey);
		$c->where(array(
				'setting' => "org_fields",
			));
		
		$conf = $this->modx->getObject($this->classKey, $c);
			if( $conf->xtype == 'array' ){
				$config_value = json_decode( $conf->value, true );
				//$data = array_merge($data, $config_value);
			}
		$list = array();
		$count = 0;
		foreach($config_value as $array){
			/* $array['actions'] = array();
			// Edit
			$array['actions'][] = array(
				'cls' => '',
				'icon' => 'icon icon-edit',
				'title' => $this->modx->lexicon('organizations_item_update'),
				//'multiple' => $this->modx->lexicon('organizations_items_update'),
				'action' => 'updateItem',
				'button' => true,
				'menu' => true,
			);

			if (!$array['active']) {
				$array['actions'][] = array(
					'cls' => '',
					'icon' => 'icon icon-power-off action-green',
					'title' => $this->modx->lexicon('organizations_item_enable'),
					'multiple' => $this->modx->lexicon('organizations_items_enable'),
					'action' => 'enableItem',
					'button' => true,
					'menu' => true,
				);
			}
			else {
				$array['actions'][] = array(
					'cls' => '',
					'icon' => 'icon icon-power-off action-gray',
					'title' => $this->modx->lexicon('organizations_item_disable'),
					'multiple' => $this->modx->lexicon('organizations_items_disable'),
					'action' => 'disableItem',
					'button' => true,
					'menu' => true,
				);
			}

			// Remove
			$array['actions'][] = array(
				'cls' => '',
				'icon' => 'icon icon-trash-o action-red',
				'title' => $this->modx->lexicon('organizations_item_remove'),
				'multiple' => $this->modx->lexicon('organizations_items_remove'),
				'action' => 'removeItem',
				'button' => true,
				'menu' => true,
			); */
			$list[] = $array;
			$count++;
		}
		//$list = $this->iterate($config_value);
        return $this->outputArray($list, $count);
    }

}

return 'OrganizationsSettingGetListProcessor';