<?php

define('MODX_API_MODE', true);
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';

$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);

//$Organizations = $modx->getService('organizations', 'Organizations', $modx->getOption('organizations_core_path', null, $modx->getOption('core_path') . 'components/organizations/') . 'model/organizations/');
$modx->lexicon->load('organizations:default');

// handle request
$corePath = $modx->getOption('organizations_core_path', null, $modx->getOption('core_path') . 'components/organizations/');
$path = $modx->getOption('processorsPath', $Organizations->config, $corePath . 'processors/');

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	$modx->sendRedirect($modx->makeUrl($modx->getOption('site_start'), '', '', 'full'));
}
elseif (empty($_REQUEST['action'])) {
	$response = array(
			'success' => false,
			'message' => $this->modx->lexicon('err_action_ns', array()),
			'data' => $data,
		);
echo $modx->toJSON($response);
}else {
	//echo '111';
	if($_REQUEST['action'] == 'orgs/testorg'){
		$pkg = 'organizations';
		$modelpath = $modx->getOption('core_path') . 'components/organizations/model/';
		$modx->addPackage($pkg, $modelpath);
		$classKey = 'Orgs';
		$c = $modx->newQuery($classKey);
		$c->where(array(
				'shortname' => $_REQUEST['shortname'],
				'inn' => $_REQUEST['inn'],
			));
		if($org = $modx->getObject($classKey, $c)){
			$response = array(
				'success' => true,
				'message' => 'inn '.$_REQUEST['inn'],
				'data' => array('exist'=>true),
			);
			echo $modx->toJSON($response);
		}else{
			$response = array(
				'success' => true,
				'message' => 'inn '.$_REQUEST['inn'],
				'data' => array('exist'=>false),
			);
			echo $modx->toJSON($response);
		}
	}else{
		$response = $modx->runProcessor('web/'.$_REQUEST['action'], $_REQUEST, array( 'processors_path' => $path));
		if($response->isError()){
			echo $modx->toJSON($modx->error->failure($response->getMessage()));
			echo '22';
		}
		echo $modx->toJSON($response);
	}
	
}
