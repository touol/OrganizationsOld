<?php

$settings = array();

$tmp = array(
	'DaDataAPI' => array(
		'xtype' => 'textfield',
		'value' => '',
		'area' => 'general',
	),
	'managerGroups' => array(
		'xtype' => 'textfield',
		'value' => '3',
		'area' => 'general',
	),
	'userGroups' => array(
		'xtype' => 'textfield',
		'value' => '2',
		'area' => 'general',
	),
);

foreach ($tmp as $k => $v) {
	/* @var modSystemSetting $setting */
	$setting = $modx->newObject('modSystemSetting');
	$setting->fromArray(array_merge(
		array(
			//'key' => 'organizations_' . $k,
			'key' => $k,
			'namespace' => PKG_NAME_LOWER,
		), $v
	), '', true, true);

	$settings[] = $setting;
}

unset($tmp);
return $settings;
