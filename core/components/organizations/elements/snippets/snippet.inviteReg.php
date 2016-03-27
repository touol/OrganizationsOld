<?php
//$modx->setPlaceholder('inv.error','Нет кода инвайта!');
if(isset($_GET['invite_code'])){
    $invite_code = $_GET['invite_code'];
    if (!$Orgs = $modx->getService('organizations', 'Organizations',$modx->getOption('organizations_core_path', null, $modx->getOption('core_path') . 'components/organizations/') . 'model/organizations/', $scriptProperties)) {
    	$modx->setPlaceholder('inv.error','Could not load Organizations class!');
    	return '';
    	
    }

    if(!$invite = $modx->getObject('OrgsInvites',array('invite_code'=>$invite_code))){
        $modx->setPlaceholder('inv.error','Код инвайта: $invite_code не зарегистрирован!');
        return "";
    }
    if($invite->used){
        $modx->setPlaceholder('inv.error',"Код инвайта: $invite_code уже использован!");
        return "";
    }
    $date_exp = strftime('%Y-%m-%d %H:%M:%S',strtotime($invite->date_exp));
    if($invite->date_exp != '0000-00-00 00:00:00'){
        if(new DateTime($invite->date_exp) >new DateTime()){
            $modx->setPlaceholder('inv.error',"Код инвайта: $invite_code просрочен!");
            return "";
        }
    }
    if($invite->org_id){
        $Org = $modx->getObject('Orgs',$invite->org_id);
        $modx->setPlaceholder('inv.shortname',$Org->shortname);
        $modx->setPlaceholder('inv.inn',$Org->inn);
    }
    //$modx->setPlaceholder('inv.shortname',$invite->shortname);
    $modx->setPlaceholder('inv.fullname',$invite->fullname);
    $modx->setPlaceholder('inv.email',$invite->email);
    $modx->setPlaceholder('inv.invite_code',$invite->invite_code);
    return '';
}