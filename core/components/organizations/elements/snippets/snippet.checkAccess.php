<?php
if (!$Orgs = $modx->getService('organizations', 'Organizations',$modx->getOption('organizations_core_path', null, $modx->getOption('core_path') . 'components/organizations/') . 'model/organizations/', $scriptProperties)) {
	return 'Could not load Organizations class!';
}
$access = $modx->getOption('access', $scriptProperties, 'access');
$trueTpl = $modx->getOption('trueTpl', $scriptProperties, 'trueTpl');
$falseMsg = $modx->getOption('falseMsg', $scriptProperties, 'Нет прав');
$falseTpl = $modx->getOption('falseTpl', $scriptProperties, '');
if($access == 'access'){
    return 'Не задано проверяемое право доступа!';
}
$shortname=$Orgs->getDefaultOrgShortame();
//проверка прав
if($Orgs->testAccess($access)){
    return $modx->getChunk($trueTpl, array('shortname'=>$shortname));
}else{
    if($falseTpl !=''){
        return $modx->getChunk($falseTpl, array('shortname'=>$shortname));
    }
    return $falseMsg;
}