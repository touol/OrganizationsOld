<?php

$menus = array();

$tmp = array(
	'organizations' => array(
		
		'description' => 'organizations_menu_desc',
		'parent' => 'components',
		'action' => 'home',
	),
	'orgs_settings' => array(
		'description' => 'organizations_settings_menu_desc',
		'parent' => 'organizations',
		'action' => 'settings',
	)
);

$i = 0;
foreach ($tmp as $k => $v) {
	/* @var modMenu $menu */
	$menu = $modx->newObject('modMenu');
	$menu->fromArray(array_merge(
		array(
			'namespace' => 'organizations',
			'text' => $k,
			'parent' => 'components',
			'icon' => 'images/icons/plugin.gif',
			'menuindex' => $i,
			'params' => '',
			'handler' => '',
		), $v
	), '', true, true);

	if (!empty($action) && $action instanceof modAction) {
		$menu->addOne($action);
	}

	$menus[] = $menu;
	$i++;
}

unset($action, $menu, $i);
return $menus;