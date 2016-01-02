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
		$config_value = json_decode( $conf->value, true );
		//$data = array_merge($data, $config_value);
	}
return $conf->value;
