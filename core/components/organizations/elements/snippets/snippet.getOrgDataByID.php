<?php
if (!$Orgs = $modx->getService('organizations', 'Organizations',$modx->getOption('organizations_core_path', null, $modx->getOption('core_path') . 'components/organizations/') . 'model/organizations/', $scriptProperties)) {
	return 'Could not load Organizations class!';
}
$id = $modx->getOption('id', $scriptProperties, '0');
$tpl = $modx->getOption('tpl', $scriptProperties, 'viewOrgData');
if($id == 0){
	return '';
}
if($org = $modx->getObject('Orgs', $id)){
	$OrgData = $org->toArray();
	return $modx->getChunk($tpl, $OrgData);
}
return '';