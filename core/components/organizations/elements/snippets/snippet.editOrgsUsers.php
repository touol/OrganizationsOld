<?php
if (!$Orgs = $modx->getService('organizations', 'Organizations',$modx->getOption('organizations_core_path', null, $modx->getOption('core_path') . 'components/organizations/') . 'model/organizations/', $scriptProperties)) {
	return 'Could not load Organizations class!';
}

$editUserOrgOuter = $modx->getOption('editUserOrgOuter', $scriptProperties, 'editUserOrgOuter');
$editUserOrgRow = $modx->getOption('editUserOrgRow', $scriptProperties, 'editUserOrgRow');
$inviteOrgRow = $modx->getOption('inviteOrgRow', $scriptProperties, 'inviteOrgRow');
$submitVar = $modx->getOption('submitVar', $scriptProperties, 'update-user-org-btn');
$outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");

$invite_email_tpl = $modx->getOption('invite_email_user_tpl', null, 'invite_email_user_tpl');
$invite_email_subject = $modx->getOption('invite_email_subject', null, 'Приглашение на сайт!');

$classKey ='OrgsUsersLink';
$classKey1 ='OrgsInvites';

$userId = $modx->user->get('id');
//получить огр пользователя по умолчанию
$defaultOrg = $Orgs->getDefaultOrg($userId);
//получаем данные орг
if($defaultOrg !=0){
    //проверка прав на просмотр пользователей организации
    if(!$Orgs->testAccess('list_org_users', $defaultOrg)){
        return "Ошибка. Нет прав на просмотр пользователей.";
    }
    //обновление данных пользователей
    if(!empty($_GET['action'])){
        if($_GET['action']=='power' and !empty($_GET['user_link_id'])){
            if($user=$modx->getObject($classKey, $_GET['user_link_id'])){
                if($user->active){$user->active=false;}else{$user->active=true;}
                $user->save();
            }
        }
        //отправка инвайта 
        if($_GET['action']=='sendInvite' and !empty($_GET['invite_id'])){
            if($invite=$modx->getObject($classKey1, $_GET['invite_id'])){
                $data=$invite->toArray();//org_id createdby_user_id
                if($org1=$modx->getObject('Orgs',$data['org_id'])){
    		        $data['org_shortname']=$org1->shortname;
    		    }
    		    if($user1=$modx->getObject('modUserProfile',array('internalKey'=>$data['createdby_user_id']))){
    		        $data['createdby_user']=$user1->fullname;
    		    }
            	$body = $modx->getChunk($invite_email_tpl, $data);
            	$invite->email_sended = $Orgs->sendEmail($data['email'], $invite_email_subject, $body);
                $invite->save();
            }
        }
        //deleteInvite
        if($_GET['action']=='deleteInvite' and !empty($_GET['invite_id'])){
            if($invite=$modx->getObject($classKey1, $_GET['invite_id'])){
               $invite->remove(); 
            }
        }
    }
    if(!empty($_POST['submitVar'])){
        //изменить группу пользователя
        if($_POST['submitVar']=='OrgEditUser' and !empty($_POST['user_link_id'])){
            if($user=$modx->getObject($classKey, $_POST['user_link_id'])){
                $user->user_group_id=$_POST['user_group_id'];
                $user->save();
            }
        }
        //создать инвайт
        
        if($_POST['submitVar']=='OrgCreateInvite' and !empty($_POST['email'])){
            
            if($invite=$modx->newObject($classKey1)){
                $data = array(
                    'type'=>3,
                    'org_id'=>$defaultOrg,
                    'createdon'=>strftime('%Y-%m-%d %H:%M:%S',strtotime("now")),
                    'invite_code'=>$Orgs->generate(6, 'IUF-'),
                    'fullname'=>$_POST['fullname'],
                    'email'=>$_POST['email'],
                    'user_group_id'=>$_POST['user_group_id'],
                    'createdby_user_id'=>$modx->user->get('id'),
                    );
                $invite->fromArray($data);
                $invite->save();
                //email //org_id createdby_user_id
        		if(!empty($_POST['email_send'])){
        		    if($org1=$modx->getObject('Orgs',$data['org_id'])){
        		        $data['org_shortname']=$org1->shortname;
        		    }
        		    if($user1=$modx->getObject('modUserProfile',array('internalKey'=>$data['createdby_user_id']))){
        		        $data['createdby_user']=$user1->fullname;
        		    }
        			$body = $modx->getChunk($invite_email_tpl, $data);
        			$invite->email_sended = $Orgs->sendEmail($data['email'], $invite_email_subject, $body);
                    $invite->save();
        		}
            }
        }
    }
//вывод таблицы пользователей
    $list = array();
    
    $c = $modx->newQuery($classKey);
    $c->leftJoin('modUser','modUser', '`'.$classKey.'`.`user_id` = `modUser`.`id`');
    $c->leftJoin('modUserProfile','modUserProfile', '`'.$classKey.'`.`user_id` = `modUserProfile`.`internalKey`');
	$c->leftJoin('Orgs','Orgs', '`'.$classKey.'`.`org_id` = `Orgs`.`id`');
	$c->leftJoin('OrgsUsersGroups','OrgsUsersGroups', '`'.$classKey.'`.`user_group_id` = `OrgsUsersGroups`.`id`');
	$Columns = $modx->getSelectColumns($classKey, $classKey, '', '', true);
	$c->select($Columns . ', `modUser`.`username` as `username`, `Orgs`.`shortname` as `shortname`, `modUserProfile`.`fullname` as `fullname`, `OrgsUsersGroups`.`name` as `user_group_name`');
    $c->where(array(
				'`'.$classKey.'`.`org_id`' => $defaultOrg,
			));
    if($Users=$modx->getIterator($classKey, $c)){
        foreach($Users as $user){
            $row =$user->toArray();
            if($user->user_id==$userId) $row['hidden']='display:none';
            if($row['active']){
                $row['active_ru']='Да';
                $row['active_color']='Green';
                $row['power_color']='Red';
                
            }else{
                $row['active_ru']='Нет';
                $row['active_color']='Red';
                $row['power_color']='Green';
            }
            $list[] = $modx->getChunk($editUserOrgRow, $row);
        }
    }else{return "Ошибка. список пользователей не загрузился.";}
    //группы пользователей организаций
    $sel_user_group ='';
    if($UserGroups=$modx->getIterator('OrgsUsersGroups')){
        foreach($UserGroups as $UserGroup){
            $sel_user_group .= '<option value="'.$UserGroup->id.'">'.$UserGroup->name.'</option>';
        }
    }
    $usersOrg = implode($outputSeparator, $list);
    
    //инвайты список
    $classKey ='OrgsInvites';
    $list1 = array();
    $c = $modx->newQuery($classKey);
    $c->leftJoin('OrgsUsersGroups','OrgsUsersGroups', '`'.$classKey.'`.`user_group_id` = `OrgsUsersGroups`.`id`');
    $Columns = $modx->getSelectColumns($classKey, $classKey, '', '', true);
    $c->select($Columns . ', `OrgsUsersGroups`.`name` as `user_group_name`');
    $c->where(array(
				'`'.$classKey.'`.`org_id`' => $defaultOrg,
			));
    if($Invites=$modx->getIterator($classKey, $c)){
        foreach($Invites as $invite){
            $row =$invite->toArray();
            if($row['used']){
                $row['used_ru']='Да';
                $row['used_color']='Green';
            }else{
                $row['used_ru']='Нет';
                $row['used_color']='Red';
            }
            if($row['email_sended']){
                $row['sended_ru']='Да';
                $row['sended_color']='Green';
            }else{
                $row['sended_ru']='Нет';
                $row['sended_color']='Red';
            }
            $list1[] = $modx->getChunk($inviteOrgRow, $row);
        }
        
    }
    $invitesOrg = implode($outputSeparator, $list1);
    
    return $modx->getChunk($editUserOrgOuter, array(
        'orgId'=>$defaultOrg,
        'usersOrg'=>$usersOrg,
        'sel_user_group'=>$sel_user_group,
        'invitesOrg'=>$invitesOrg,
        ));
}else{
    return "Ошибка. Не найдена Организация.";
}