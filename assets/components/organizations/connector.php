<?php
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var Organizations $Organizations */
$Organizations = $modx->getService('organizations', 'Organizations', $modx->getOption('organizations_core_path', null, $modx->getOption('core_path') . 'components/organizations/') . 'model/organizations/');
$modx->lexicon->load('organizations:default');

// handle request
$corePath = $modx->getOption('organizations_core_path', null, $modx->getOption('core_path') . 'components/organizations/');
$path = $modx->getOption('processorsPath', $Organizations->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path,
	'location' => '',
));