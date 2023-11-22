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
		
		$this->pdo = $modx->getService('pdofetch','pdoFetch',
			$modx->getOption('pdotools.core_path',null,$modx->getOption('core_path').'components/pdotools/').'model/pdotools/',$config);
		$this->pdo->setConfig($config);
		$this->pdo->addTime('pdoTools loaded');
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
			$prefix='' 
/* 			,$suffix='', 
			$numbers=true,
			$letters=true,
			$symbols=false,
			$random_register=false,
			$mask=false
			// MASK FORMAT [XXX-XXX]
			// 'X' this is random symbols
			// '-' this is sepatator */
		) { //не лицензионный код удален. Название функции для совместимости.
			$coupon = $this->rand_string($length, array('upp','num'));
			return $prefix . $coupon ;
		}
	public function rand_string($nChars, array $case = array()) {

		define ('LOW', 'abcdefghijklmnopqrstuvwxyz');
		define ('UPP', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
		define ('NUM', '1234567890');
		define ('SPEC', '^@*+-+%()!?');
		
		$symbols = array();
		if (in_array('low', $case))
			$symbols[] = LOW;
		if (in_array('upp', $case))
			$symbols[] = UPP;
		if (in_array('num', $case))
			$symbols[] = NUM;
		if (in_array('spec', $case))
			$symbols[] = SPEC;
		if (count($symbols) == 0)
			$symbols = array(LOW, UPP, NUM, SPEC);

		$rand_str = '';
		for ($i = 1; $i <= $nChars; $i++) { // циклим по числу необходимых символов в итоговой строке
			$id = mt_rand(0, count($symbols)-1); // случайным образом определяем ТИП символов, из которых будем получать случайный СИМВОЛ
			$source_str = $symbols[$id];
			$rand_str .= $source_str{ mt_rand(0, strlen($source_str)-1) }; // очередной случаный символ
		}
		return $rand_str;
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
	public function update_panosonic($data = []){
		$data = [];
		
		// for($i=0;$i<15000;$i++){
			// $n = $this->setnull($i);
			// $data[$i] = [
				// 'id'=>$n,
				// 'sysspeed_name'=>'',
				// 'sysspeed_dial'=>"",
				// 'sysspeed_ext'=>"",
				// '_id_'=>$n,
			// ];
		// }
		
		// $contacts = $this->modx->getIterator("OrgsContact");
		// foreach($contacts as $c){
			// $data[$c->id]['sysspeed_name'] = $c->shortname;
			// $data[$c->id]['sysspeed_dial'] = '9'.$c->phone;
		// }
		$default = [
			'class'=>'OrgsContact',
            'subpdo'=>[
			    'OrgsContactLink'=>[
			        'class'=>'OrgsContactLink',
			        'leftJoin'=>[
                        'Orgs'=>[
                            'class' => 'Orgs',
                            'on' => 'Orgs.id = OrgsContactLink.org_id',
                        ],
						'OrgsContactManager'=>[
                            'class' => 'OrgsContactManager',
                            'on' => 'OrgsContactManager.manager_id = Orgs.manager_id',
                        ],
                    ],
			        'where' => [
        				'OrgsContact.id = OrgsContactLink.contact_id',
        			],
        			'select'=>[
        				'OrgsContactManager'=>'OrgsContactManager.phone as manager_phone0',
        			],
        			'limit'=>1,
			    ],
			],
			'select'=>[
				'OrgsContact'=>'OrgsContact.id,OrgsContact.shortname,OrgsContact.phone,({$subpdo.OrgsContactLink}) as manager_phone',
			],
			'return'=>'data',
			'limit'=>0,
		];
		$this->pdo->setConfig($default);
		$contacts = $this->pdo->run();
		$i = 0;
		foreach($contacts as $c){
			$n = $this->setnull($i);
			$data[] = [
				'id'=>$n,
				'sysspeed_name'=>$c['shortname'],
				'sysspeed_dial'=>'9'.$c['phone'],
				'sysspeed_ext'=>$c['manager_phone'],
				'_id_'=>$n,
			];
			$i++;
		}
		//return $this->error("Нет получателей! ".print_r($data,1));
		// $this->modx->log(1,"получателей ".print_r($data,1));
		// $out = '"System Speed Dialling Number","Name (20 characters)","CO Line Access Number + Telephone Number (32 digits)","CLI Destination"
// "0","Саша комп","Dial=989233265456","Dial="
// "1","","Dial=","Dial="
// "2","","Dial=","Dial="';
		// for($i=3;$i<=5000;$i++){
			// $out .="\r\n".'"'.$i.'","","Dial=","Dial="';
		// }
		// file_put_contents("C:\\1.csv",$out);
		return $this->send_ats($data);
	}
	public function setnull($i){
		$n = 4 - strlen($i);
		$out = "";
		for($j=0;$j<$n;$j++){
			$out .= "0";
		}
		return $out.$i;
	}
	public function send_ats($data = []){
		//update_panosonic
		$ch = curl_init();
		$dataString = "_method=POST&data%5BUser%5D%5BforcedLogin%5D=1&data%5BUser%5D%5BreadOnly%5D=&data%5BUser%5D%5Busername%5D=427k%3D0%3DkUt422k%3D0%3DkTy417k%3D0%3DkBc416k%3D0%3DkOd435k%3D0%3DkIl424k%3D0%3DkSw424k%3D0%3DkSw431k%3D0%3DkRp418k%3D0%3DkEb&data%5BUser%5D%5Bpassword%5D=451k%3D0%3DkSw381k%3D0%3DkIl402k%3D0%3DkNr387k%3D0%3DkOf384k%3D0%3DkHi390k%3D0%3DkBc449k%3D0%3DkTy381k%3D0%3DkIl";

		$dir = dirname(__FILE__);
		$config['cookie_file'] = $dir."/".md5($_SERVER['REMOTE_ADDR']) . '.txt';

		curl_setopt($ch, CURLOPT_URL, 'http://192.168.0.84/WebMC/users/login');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		//curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
		//curl_setopt($ch, CURLOPT_COOKIEFILE, $config['cookie_file']);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $config['cookie_file']);

		$headers = array();
		$headers[] = 'Connection: keep-alive';

		$headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
		$headers[] = 'Dnt: 1';
		$headers[] = 'X-Requested-With: XMLHttpRequest';
		$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36';
		//$headers[] = 'Content-Type: application/json';
		$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
		$headers[] = 'Content-Length: ' . strlen($dataString);
		$headers[] = 'Origin: http://192.168.0.84';
		$headers[] = 'Referer: http://192.168.0.84/WebMC/index/';
		$headers[] = 'Accept-Language: ru,en-US;q=0.9,en;q=0.8';
		//$headers[] = 'Cookie: PHPSESSID=38qaur2763n41atnqmjdglvah7';
		//$headers[] = 'Expect:  ';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec ($ch);

		if ($result === FALSE) {
			//echo "Error sending" . $fname .  " " . curl_error($ch);
			return $this->error("Нет доступа к атс! 0");
			curl_close ($ch);
		}elseif($result == ""){
			//echo  $result;
			//return $this->error("Нет доступа к атс! $result");
			$dataString = "data=".json_encode($data);
			
			curl_setopt($ch, CURLOPT_URL, 'http://192.168.0.84/WebMC/GridForm/SaveData/?api=PBX_Feature.SysSpdDial&memory=0');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $config['cookie_file']);
			curl_setopt($ch, CURLOPT_COOKIEJAR, $config['cookie_file']);
			
			$headers = array();
			$headers[] = 'Connection: keep-alive';

			$headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
			$headers[] = 'Dnt: 1';
			$headers[] = 'X-Requested-With: XMLHttpRequest';
			$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36';
			//$headers[] = 'Content-Type: application/json';
			$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
			$headers[] = 'Content-Length: ' . strlen($dataString);
			$headers[] = 'Origin: http://192.168.0.84';
			$headers[] = 'Referer: http://192.168.0.84/WebMC/index/';
			$headers[] = 'Accept-Language: ru,en-US;q=0.9,en;q=0.8';
			//$headers[] = 'Cookie: PHPSESSID=38qaur2763n41atnqmjdglvah7';
			$headers[] = 'Expect:  ';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec ($ch);

			if ($result === FALSE) {
				//echo "Error sending" . $fname .  " " . curl_error($ch);
				return $this->error("Нет доступа к атс! ");
				curl_close ($ch);
			}else{
				curl_close ($ch);
				$resp = json_decode($result,1);
				if($resp[0]['error'] == 0)
					return $this->success([],"Успешно импортированно!");
				
				return $this->error("Ответ! $result".print_r($resp,1));
			}
		}else{
			return $this->error("Нет доступа к атс! $result");
		}
	}
	
	public function export_ca($data = [])
    {
        
        //$table['pdoTools']['limit'] = 0;
        // echo "<pre>".print_r($data,1)."</pre>";
		// echo "<pre>".print_r($_GET,1)."</pre>";
		$where["Orgs.manager_id"] = $data["manager_id"];
		$default = [
			'class'=>'OrgsContact',

			'leftJoin'=>[
				'OrgsContactLink'=>[
					'class' => 'OrgsContactLink',
					'on' => 'OrgsContact.id = OrgsContactLink.contact_id',
				],
				'Orgs'=>[
					'class' => 'Orgs',
					'on' => 'Orgs.id = OrgsContactLink.org_id',
				],
			],
			'groupby'=>'OrgsContact.id',
			'where'=>$where,
			'select'=>[
				'OrgsContact'=>'OrgsContact.id,OrgsContact.shortname,OrgsContact.phone',
			],
			'return'=>'data',
			'limit'=>0,
		];
		$this->pdo->setConfig($default);
		$contacts = $this->pdo->run();
		//echo "<pre>".print_r($contacts,1)."</pre>";
		$str = '"Extension/Other'."\n".
'  Type: Number'."\n".
'    0: Extension'."\n".
'    1: Door & Sensor'."\n".
'  Max: 1 digit","Contact Name'."\n".
'  Type: ASCII character'."\n".
'  Max: 32 chars(bytes)","Last Name'."\n".
'  Type: Character'."\n".
'  Max: 20 chars","First Name'."\n".
'  Type: Character'."\n".
'  Max: 20 chars","Contact Device'."\n".
'  Type: Number'."\n".
'    0: Phone'."\n".
'    1: Door'."\n".
'    2: Sensor'."\n".
'  Max: 1 digit","Door No'."\n".
'  Type: Number'."\n".
'  Max: 2 digits","Sensor No'."\n".
'  Type: Number'."\n".
'  Max: 2 digits","Phone(Office)'."\n".
'  Type: Number'."\n".
'  Max: 64 digits","Phone(Mobile)'."\n".
'  Type: Number'."\n".
'  Max: 64 digits","Phone(Home)'."\n".
'  Type: Number'."\n".
'  Max: 64 digits","Phone(Secretary)'."\n".
'  Type: Number'."\n".
'  Max: 64 digits","VM Number'."\n".
'  Type: Number'."\n".
'  Max: 64 digits","E-mail 1'."\n".
'  Type: Character'."\n".
'  Max: 256 chars","E-mail 2'."\n".
'  Type: Character'."\n".
'  Max: 256 chars","Group'."\n".
'  Type: Character'."\n".
'  Max: 128 chars","Company Name'."\n".
'  Type: Character'."\n".
'  Max: 64 chars","Department'."\n".
'  Type: Character'."\n".
'  Max:  64 chars","Section'."\n".
'  Type: Character'."\n".
'  Max: 64 chars","Address'."\n".
'  Type: Character'."\n".
'  Max: 128 chars","Postal Code'."\n".
'  Type: Character'."\n".
'  Max: 16 chars","FAX'."\n".
'  Type: Number'."\n".
'  Max: 64 digits","Image File'."\n".
'  Type: Character'."\n".
'  Max: 256 chars","Ring File'."\n".
'  Type: Character'."\n".
'  Max: 256 chars","1st URL'."\n".
'  Type: Character'."\n".
'  Max: 256 chars","2nd URL'."\n".
'  Type: Character'."\n".
'  Max: 256 chars","3rd URL'."\n".
'  Type: Character'."\n".
'  Max: 256 chars","Memo'."\n".
'  Type: Character'."\n".
'  Max: 256 chars",Server ID
0,101,,,0,,,101,,,,500,,,Business,,,1:,,,,,,,,,,
0,102,,,0,,,102,,,,500,,,Business,,,1:,,,,,,,,,,
0,103,,,0,,,103,,,,500,,,Business,,,1:,,,,,,,,,,
0,104,,,0,,,104,,,,500,,,Business,,,1:,,,,,,,,,,
0,105,,,0,,,105,,,,500,,,Business,,,1:,,,,,,,,,,
0,106,,,0,,,106,,,,500,,,Business,,,1:,,,,,,,,,,
0,107,,,0,,,107,,,,500,,,Business,,,1:,,,,,,,,,,
0,108,,,0,,,108,,,,500,,,Business,,,1:,,,,,,,,,,
1,109,,,0,,,109,,,,500,,,Business,,,1:,,,,,,,,,,
1,110,,,0,,,110,,,,500,,,Business,,,1:,,,,,,,,,,
0,111,,,0,,,111,,,,500,,,Business,,,1:,,,,,,,,,,
';
		foreach($contacts as $c){
			//shortname,OrgsContact.phone
			if(!empty($c['phone'])) $str .= '0,"'.$c['shortname'].'",,,0,,,'.$c['phone'].',,,,500,,,Business,,,1:,,,,,,,,,,'."\r\n";
		}
		
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename="export_ca_manager_id_'.$data["manager_id"].'.csv";');
		echo $str;
		exit();
    }
	public function handleRequest($action, $data = array())
    {
		//return $this->error("!1".print_r($data,1));
		if(method_exists($this,$action)){
			return $this->{$action}($data);
		}else{
			$class = get_class($this);
			return $this->error("Метод $action в классе $class не найден!");
		}
    }
	public function success($data = [], $message = ""){
		return array('success'=>1,'message'=>$message,'data'=>$data);
	}
	public function error($message = "",$data = []){
		return array('success'=>0,'message'=>$message,'data'=>$data);
	}
}