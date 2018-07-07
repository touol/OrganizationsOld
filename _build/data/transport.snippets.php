<?php

$snippets = array();

$tmp = array(
	'CheckConteiner' => array(
		'file' => 'CheckConteiner',
		'description' => 'Проверка, что при регистрации введено имя организации.',
	),
	'checkAccess' => array(
		'file' => 'checkAccess',
		'description' => 'Проверяет права пользователей организации.',
	),
	'editOrgsUsers' => array(
		'file' => 'editOrgsUsers',
		'description' => 'Показывает пользователей организации и инвайты в нее.',
	),
	'getDefaultUserOrg' => array(
		'file' => 'getDefaultUserOrg',
		'description' => 'Показывает форму редактирования, просмотра данных организации.',
	),
	'inviteReg' => array(
		'file' => 'inviteReg',
		'description' => 'Подставляет данные организации в форму регистрации пользователя при полученном инвайте организации.',
	),
	'loginRegisterHook' => array(
		'file' => 'loginRegisterHook',
		'description' => 'Вносит данные организации из формы loginRegister и привязывает пользователя к организации.',
	),
	'orgsTVSelect' => array(
		'file' => 'orgsTVSelect',
		'description' => 'Сниппет для вывода списка организаций в TV список.',
	),
	'getOrgDataByID' => array(
		'file' => 'getOrgDataByID',
		'description' => 'Простой сниппет для вывода данных организации.',
	),
);

foreach ($tmp as $k => $v) {
	/* @avr modSnippet $snippet */
	$snippet = $modx->newObject('modSnippet');
	$snippet->fromArray(array(
		'id' => 0,
		'name' => $k,
		'description' => @$v['description'],
		'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.' . $v['file'] . '.php'),
		'static' => BUILD_SNIPPET_STATIC,
		'source' => 1,
		'static_file' => 'core/components/' . PKG_NAME_LOWER . '/elements/snippets/snippet.' . $v['file'] . '.php',
	), '', true, true);

	$properties = include $sources['build'] . 'properties/properties.' . $v['file'] . '.php';
	$snippet->setProperties($properties);

	$snippets[] = $snippet;
}

unset($tmp, $properties);
return $snippets;