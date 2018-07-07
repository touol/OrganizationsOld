<?php
if (!$Orgs = $modx->getService('organizations', 'Organizations',$modx->getOption('organizations_core_path', null, $modx->getOption('core_path') . 'components/organizations/') . 'model/organizations/', $scriptProperties)) {
	return 'Could not load Organizations class!';
}

//$modx->log(modX::LOG_LEVEL_ERROR, 'loginRegisterHook ');
    $pkg = 'organizations';
	$modelpath = $modx->getOption('core_path') . 'components/organizations/model/';
	$modx->addPackage($pkg, $modelpath);
		
$formFields = $hook->getValues();
$userId=$formFields['register.user']->id;
$username=$formFields['register.user']->username;
$fullname=$formFields['register.profile']->fullname;
$OrgData=$formFields['org'];
//обработка инвайтов
$invite_code=$formFields['invite_code'];
if($invite_code!=''){
    if($invite = $modx->getObject('OrgsInvites',array('invite_code'=>$invite_code))){
        // создаем связь между пользователем созданным login.register и организацией
        if($orgUserLink = $modx->newObject('OrgsUsersLink')){
            switch($invite->type){
                case 1: case 3:
                    $org_id = $invite->org_id;
                    if($invite->used){
                        return false;
                    }
                    $invite->used = true;
                    $invite->used_user_id=$userId;
                    $invite->save();
                break;
                default:
                    
                break;
            }
            $data = array(
                'org_id'=>$org_id,
                'user_id'=>$userId,
                'user_group_id'=>$invite->user_group_id,
                'active'=>true,
                );
            $orgUserLink->fromArray($data);
            if($orgUserLink->save()){
				// создаем настройки пользователя
				if($orgUser = $modx->newObject('OrgsUsers')){
					$data = array(
						//'default_org_id'=>$org_id,
						'user_id'=>$userId,
						);
					$orgUser->fromArray($data);
					$orgUser->save();
				}
				return true;
			}
        }
    }
    return false;
}
//$modx->log(modX::LOG_LEVEL_ERROR, 'loginRegisterHook userID '.$userId);
//unset($formFields['register.user']);
//unset($formFields['register.profile']);
//$modx->log(modX::LOG_LEVEL_ERROR, 'formFields '.print_r($formFields,true));
//проверка есть ли уже организация
$classKey = 'Orgs';
$c = $modx->newQuery($classKey);
$c->where(array(
		'shortname' => $OrgData['shortname'],
		'inn' => $OrgData['inn'],
	));
$AdminGroupID=1; //группа Администраторы
$groupID=3; // группа подключения пользователей 
$active = false; 
if(!$org = $modx->getObject($classKey, $c)){
    //если нет такой огр. то создание организации и пользователю права админа
    if($org = $modx->newObject($classKey)){
        $OrgData['active']=true;
        $org->fromArray($OrgData);
        $org->save();
    }else{
        return false;
    }
    $groupID=$AdminGroupID; 
    $active = true;
}
// создаем связь между пользователем созданным login.register и организацией
if($orgUserLink = $modx->newObject('OrgsUsersLink')){
    $data = array(
        'org_id'=>$org->id,
        'user_id'=>$userId,
        'user_group_id'=>$groupID,
        'active'=>$active,
        );
    $orgUserLink->fromArray($data);
    $orgUserLink->save();
}
// создаем настройки пользователя
if($orgUser = $modx->newObject('OrgsUsers')){
    $data = array(
        //'default_org_id'=>$org->id,
		'user_id'=>$userId,
        );
    $orgUser->fromArray($data);
    $orgUser->save();
}
//если орг. не новая отправляем сообщение администраторам организации
if(!$active){
    $c = $modx->newQuery('OrgsUsersLink');
    $c->where(array(
        'org_id'=>$org->id,
        'user_group_id'=>$AdminGroupID,
        'active'=>true,
    ));
    
    $admins = $modx->getCollection('OrgsUsersLink',$c);
    $msg_str = "К Вашей организации подключается пользователь: \n";
    $msg_str .= "Логин: $username \n";
    $msg_str .= "ФИО: $fullname. \n";
    $msg_str .= "Если Вы уверенны, что ему необходимо предоставить доступ, включите его и настройте ему права в настройках Вашей организации. \n";
    foreach ($admins as $adm){
        sendMsgAdmin($userId,$adm->user_id,$msg_str,$modx);
    }    
}

function sendMsgAdmin($userid,$to,$msg_str,$modx){
    $msg = $modx->newObject('modUserMessage');
    $msg->fromArray(array(
       'sender' => $userid,
         'recipient' => $to,
         'message' => $msg_str,
         'subject' => 'Новый пользователь в Вашей организации',
         'read' => 0,
         'private' => 1,
         'date_sent'=> strftime('%Y-%m-%d %H:%M:%S'),
    ));
    $msg->save();
}