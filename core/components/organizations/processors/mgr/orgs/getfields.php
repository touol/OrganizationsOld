<?php
/**
 * Get a getFields of Setting
 */

$objectType = 'OrgsConfig';
$classKey = 'OrgsConfig';

$c = $modx->newQuery($classKey);
$c->where(array(
		'setting' => "org_fields",
	));

$conf = $modx->getObject($classKey, $c);
	if( $conf->xtype == 'array' ){
		$config_value = json_decode( $conf->value, true);
	}
	$count = 0;//count($config_value);
	//return '{"success":true,"message":"","total":"'.$count.'","object":'.$this->modx->toJSON($conf->toArray()).',"data":'.$this->modx->toJSON(array()).'}';
return $conf->value;
