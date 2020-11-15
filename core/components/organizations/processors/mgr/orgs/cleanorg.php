<?php
set_time_limit(3600);
$modx->getService('lexicon','modLexicon');
$modx->lexicon->load($modx->config['manager_language'].':organizations:default');

$modx->addPackage('organizations', $modx->getOption('core_path') . 'components/organizations/model/');

if ((include MODX_ASSETS_PATH.'components/organizations/PHPExcel/IOFactory.php') != TRUE) {
    $modx->log(modX::LOG_LEVEL_ERROR,'Не удалось загрузить PHPExcel!');
	$modx->log(modX::LOG_LEVEL_INFO,'COMPLETED');
	sleep(1);
	return $modx->error->success();
}
$excel_file = MODX_BASE_PATH.$_POST['excel_file'];
$remove_users = $_POST['remove_users'];

$inputFileType = PHPExcel_IOFactory::identify($excel_file);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
try {
    if (!($objPHPExcel = $objReader->load($excel_file))) {
        $modx->log(modX::LOG_LEVEL_ERROR,'Не удалось загрузить файл! '.$excel_file);
		$modx->log(modX::LOG_LEVEL_INFO,'COMPLETED');
		sleep(1);
        return $modx->error->success();
    }
} catch(Exception $e) {
    $modx->log(modX::LOG_LEVEL_ERROR,'Не удалось загрузить файл! Exception. '.$excel_file);
	$modx->log(modX::LOG_LEVEL_INFO,'COMPLETED');
	sleep(1);
	return $modx->error->success();
}
$ar = $objPHPExcel->getActiveSheet()->toArray();
$count = 0;
foreach($ar as $ar_colls){
	if($ar_colls[0] == "1"){
		if(!$org = $modx->getObject('Orgs',$ar_colls[2])){
			$modx->log(modX::LOG_LEVEL_ERROR,'Не найдена организация id = '.$ar_colls[2].' shortname = '.$ar_colls[3]);
		}else{
			if($remove_users){
				$users = $org->getMany('OrgsUsersLink');
				foreach($users as $u){
					$c = $modx->newQuery('OrgsUsersLink');
					$c->where(array(
						'`OrgsUsersLink`.`user_id`' => $u->user_id,
						'`OrgsUsersLink`.`org_id`:!=' => $org->id,
					));
					$countUser = $modx->getCount('OrgsUsersLink', $c);
					if($countUser == 0){
						if($user = $modx->getObject('modUser',$u->user_id)){
							$modx->log(modX::LOG_LEVEL_INFO,'Удаляем пользователя '.$u->user_id.' '.$user->username);
							$user->remove();
						}else{
							$modx->log(modX::LOG_LEVEL_ERROR,'Не найдена пользователь id = '.$u->user_id);
						}
					}else{
						$modx->log(modX::LOG_LEVEL_ERROR,'Пользователь есть в другой организации id = '.$u->user_id);
					}
				}
			}
			$modx->log(modX::LOG_LEVEL_INFO,'Удаляем организацию id = '.$ar_colls[2].' shortname = '.$org->shortname);
			$org->remove();
			$count++;
		}
	}
}
$modx->log(modX::LOG_LEVEL_ERROR,'Удалено '.$count.' организаций!');
$modx->log(modX::LOG_LEVEL_INFO,'COMPLETED');
sleep(1);
return $modx->error->success();
?>