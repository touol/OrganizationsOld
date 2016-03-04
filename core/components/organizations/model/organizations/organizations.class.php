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
	public function generate(
			$length=6, 
			$prefix='', 
			$suffix='', 
			$numbers=true,
			$letters=true,
			$symbols=false,
			$random_register=false,
			$mask=false
			// MASK FORMAT [XXX-XXX]
			// 'X' this is random symbols
			// '-' this is sepatator
		) {
			$numbers = $numbers == 'false' ? false : true ;
			$letters = $letters == 'false' ? false : true ;
			$symbols = $symbols == 'true' ? true : false ;
			$random_register = $random_register == 'true' ? true : false ;
			$mask = $mask == 'false' ? false : $mask ;

			$numbers   = array(0,1,2,3,4,5,6,7,8,9);
			$lowercase = array('q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m');
			$uppercase = array('Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M');
			$symbols_a = array('`','~','!','@','#','$','%','^','&','*','(',')','-','_','=','+','\\','|','/','[',']','{','}','"',"'",';',':','<','>',',','.','?');

			$string = Array();
			$coupon = '';
			if ($letters) {
				if ($random_register) {
					$string = array_merge($string, $lowercase, $uppercase);
				} else {
					$string = array_merge($string, $uppercase);
				}
			}

			if ($numbers) {
				$string = array_merge($string, $numbers);
			}

			if ($symbols) {
				$string = array_merge($string, $symbols_a);
			}

			if ($mask) {
				for ($i=0; $i < strlen($mask); $i++) { 
					if ($mask[$i] === 'X') {
						$coupon .= $string[rand(0, count($string)-1)];
					} else {
						$coupon .= $mask[$i];
					}
				}
			} else {
				for ($i=0; $i < $length ; $i++) { 
					$coupon .= $string[rand(0, count($string)-1)];
				}
			}

			return $prefix . $coupon . $suffix;
		}
	public function sendEmail($email, $subject, $body = 'no body set') {
		if (!isset($this->modx->mail) || !is_object($this->modx->mail)) {
			$this->modx->getService('mail', 'mail.modPHPMailer');
		}
		$this->modx->mail->set(modMail::MAIL_FROM, $this->modx->getOption('emailsender'));
		$this->modx->mail->set(modMail::MAIL_FROM_NAME, $this->modx->getOption('site_name'));
		$this->modx->mail->setHTML(true);
		$this->modx->mail->set(modMail::MAIL_SUBJECT, trim($subject));
		$this->modx->mail->set(modMail::MAIL_BODY, $body);
		$this->modx->mail->address('to', trim($email));
		if (!$this->modx->mail->send()) {
			$this->modx->log(modX::LOG_LEVEL_ERROR,'An error occurred while trying to send the email: '.$this->modx->mail->mailer->ErrorInfo);
			$this->modx->mail->reset();
			return false;
		}
		$this->modx->mail->reset();
		return true;
	}
}