<?php
if (!$Orgs = $modx->getService('organizations', 'Organizations',$modx->getOption('organizations_core_path', null, $modx->getOption('core_path') . 'components/organizations/') . 'model/organizations/', $scriptProperties)) {
	return 'Could not load Organizations class!';
}
$q = $modx->newQuery('Orgs');
$q->select('id,shortname');

if($Orgs=$modx->getIterator('Orgs', $q)){
   $list='';
    foreach ($Orgs as $Org){
        $list.='||'.$Org->shortname.'=='.$Org->id;
    }
    return $list; 
}
return '';