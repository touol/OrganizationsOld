<?php

/**
 * The base class for Organizations.
 */
class Organizations {
	/* @var modX $modx */
	public $modx;


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('organizations_core_path', $config, $this->modx->getOption('core_path') . 'components/organizations/');
		$assetsUrl = $this->modx->getOption('organizations_assets_url', $config, $this->modx->getOption('assets_url') . 'components/organizations/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
			'imagesUrl' => $assetsUrl . 'images/',
			'connectorUrl' => $connectorUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/'
		), $config);

		$this->modx->addPackage('organizations', $this->config['modelPath']);
		$this->modx->lexicon->load('organizations:default');
	}
	function getDefaultOrgShortame($OrgId = Null, $userId = Null) {
		if(is_null($userId)){
			$userId = $this->modx->user->get('id');
		}
		if(is_null($OrgId)){
			$OrgId = $this->getDefaultOrg($userId);
			if($OrgId ==0) return "Не удалось определить ид организации!";
		}
		if($Org = $this->modx->getObject('Orgs', $OrgId) ){
			return $Org->shortname;
		}
		return "Не удалось определить имя организации!";
	}
	function getDefaultOrg($userId = Null ) {
		if(is_null($userId)){
			$userId = $this->modx->user->get('id');
		}
		$defaultOrg =0;
		//получить огр пользователя по умолчанию
		if($defaultOrg ==0){
			if($orguser = $this->modx->getObject('OrgsUsers', array('user_id'=>$userId))){
				if($orguser->default_org_id !=0){$defaultOrg = $orguser->default_org_id;}
			} 
		}
		if($defaultOrg ==0){
			if($this->modx->getCount('OrgsUsersLink', array('user_id'=>$userId)) !=0){
			   $c = $this->modx->newQuery('OrgsUsersLink');
			   $c->sortby('id', 'ASC');
			   $c->where(array(
							'`OrgsUsersLink`.`user_id`' => $userId,
							//'`OrgsUsersLink`.`active`' => 1,
						));
			   $items = $this->modx->getIterator('OrgsUsersLink', $c);
			   $lastOrgId =0;
				foreach ($items as $item) {
					$lastOrgId = $item->org_id;
				}
				$defaultOrg = $lastOrgId;
			}
		}
		return $defaultOrg;
	}
	
	function testAccess($access, $OrgId = Null, $userId = Null ) {
		if(is_null($userId)){
			$userId = $this->modx->user->get('id');
		}
		
		if(is_null($OrgId)){
			$OrgId = $this->getDefaultOrg($userId);
			if($OrgId ==0) return false;
		}
		$c = $this->modx->newQuery('OrgsUsersLink');
		$c->where(array(
						'`OrgsUsersLink`.`user_id`' => $userId,
						'`OrgsUsersLink`.`org_id`' => $OrgId,
						'`OrgsUsersLink`.`active`' => true,
					));
		$c->leftJoin('OrgsUsersGroups','OrgsUsersGroups', '`OrgsUsersLink`.`user_group_id` = `OrgsUsersGroups`.`id`');
		$c->select('`OrgsUsersGroups`.`data` as `access`');
		if($userlink = $this->modx->getObject('OrgsUsersLink', $c) ){
			$groupAccess = json_decode($userlink->access,true);
			if(isset($groupAccess[$access])){return $groupAccess[$access];}
		}
		return false;
	}
}