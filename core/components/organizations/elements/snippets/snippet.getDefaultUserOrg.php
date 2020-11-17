<?php
if (!$Orgs = $modx->getService('organizations', 'Organizations',$modx->getOption('organizations_core_path', null, $modx->getOption('core_path') . 'components/organizations/') . 'model/organizations/', $scriptProperties)) {
	return 'Could not load Organizations class!';
}
$viewOrgOuter = $modx->getOption('viewOrgOuter', $scriptProperties, 'viewOrgOuter');
$viewOrgRow = $modx->getOption('viewOrgRow', $scriptProperties, 'viewOrgRow');
$editOrgOuter = $modx->getOption('editOrgOuter', $scriptProperties, 'editOrgOuter');
$editOrgRow = $modx->getOption('editOrgRow', $scriptProperties, 'editOrgRow');
$submitVar = $modx->getOption('submitVar', $scriptProperties, 'update-org-btn');
$onlyView = $modx->getOption('onlyView', $scriptProperties, '0');
$defaultOrg = 0;
//обновление данных орг
if(!empty($_POST[$submitVar])){
    $defaultOrg = $_POST['org_id'];
    $org = $modx->getObject('Orgs', $defaultOrg);
    if($Orgs->testAccess('edit_org_data', $defaultOrg)){
        $org->fromArray($_POST);
        if($org->save()){
            $updateOrg = "Данные организации обновлены!";
        }else{
            $updateOrg = "Ошибка обновления данных организации!";
        }
    }else{
        $updateOrg = "Нет прав на редактирование!";
    }
}
$sortby = $modx->getOption('sortby', $scriptProperties, 'shortname');
$sortdir = $modx->getOption('sortbir', $scriptProperties, 'ASC');
//$limit = $modx->getOption('limit', $scriptProperties, 5);
$outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");

$userId = $modx->user->get('id');
//получить огр пользователя по умолчанию
$defaultOrg = $Orgs->getDefaultOrg($userId);
//получаем данные орг
if($defaultOrg !=0){
    //проверка прав на редактирование данных организации
    $userperm = $Orgs->testAccess('edit_org_data', $defaultOrg);
    if($userperm and $onlyView !='1'){
        //если есть права загружаем форму редактирования
        $viewOrgOuter = $editOrgOuter;
        //$viewOrgRow = $editOrgRow;
    }
    $viewOrgRow = $editOrgRow;
    $conf = $modx->getObject('OrgsConfig', array('setting'=>"org_fields"));
    if( $conf->xtype == 'array' ){
    	$org_fields = json_decode( $conf->value, true );
    }
    $org = $modx->getObject('Orgs', $defaultOrg);
    $list0 = array();$list1 = array();$list2 = array();$list3 = array();
    /** @var ChangePackItem $item */
    foreach ($org_fields as $field) {
    	if($field['active'] and $field['name']!='manager_id' and $field['name']!='discount' and $field['name']!='active'){
    	    $row = array(
    	        'name' => $field['name'],
    	        'label' => $field['label'],
    	        'value' => $org->{$field['name']},
    	        'xtype'=>$field['xtype']
    	        );
    	   switch($field['column']){
    	        case '0':
    	        $list0[] = $modx->getChunk($viewOrgRow, $row);
    	        break;
    	        case '1':
    	        $list1[] = $modx->getChunk($viewOrgRow, $row);
    	        break;
    	        case '2':
    	        $list2[] = $modx->getChunk($viewOrgRow, $row);
    	        break;
    	        case '3':
    	        $list3[] = $modx->getChunk($viewOrgRow, $row);
    	        break;
    	   }
    	}
    }
    
    // Output
    $org0 = implode($outputSeparator, $list0);
    $org1 = implode($outputSeparator, $list1);
    $org2 = implode($outputSeparator, $list2);
    $org3 = implode($outputSeparator, $list3);
    $output = $modx->getChunk($viewOrgOuter, array(
        'orgId'=>$defaultOrg,
        'org0'=>$org0,
        'org1'=>$org1,
        'org2'=>$org2,
        'org3'=>$org3,
        'org_id'=>$defaultOrg,
        'status'=>$updateOrg
        ));
    return $output;
}else{
    return "Ошибка. Не найдена Организация.";
}