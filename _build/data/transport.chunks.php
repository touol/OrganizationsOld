<?php

$chunks = array();

$tmp = array(
	'editOrgOuter' => array(
		'file' => 'editOrgOuter',
		'description' => 'Внешний чанк для редактирования данных организации.',
	),
	'editOrgRow' => array(
		'file' => 'editOrgRow',
		'description' => 'Внутрений чанк для редактирования данных организации.',
	),
	'editUserOrgOuter' => array(
		'file' => 'editUserOrgOuter',
		'description' => 'Внешний чанк для редактирования пользователей организации.',
	),
	'editUserOrgRow' => array(
		'file' => 'editUserOrgRow',
		'description' => 'Внутрений чанк для редактирования пользователей организации.',
	),
	'inviteOrgRow' => array(
		'file' => 'inviteOrgRow',
		'description' => 'Внутрений чанк для просмотра инвайтов организации.',
	),
	'invite_email_tpl' => array(
		'file' => 'invite_email_tpl',
		'description' => 'Текст емаил для приглашения пользователей от администраторов сайта.',
	),
	'invite_email_user_tpl' => array(
		'file' => 'invite_email_user_tpl',
		'description' => 'Текст емаил для приглашения пользователей от администраторов организации.',
	),
	'viewOrgOuter' => array(
		'file' => 'viewOrgOuter',
		'description' => 'Внешний чанк для просмотра данных организации.',
	),
	'viewOrgData' => array(
		'file' => 'viewOrgData',
		'description' => 'Простой чанк для просмотра данных организации.',
	),
	'pageRegistration' => array(
		'file' => 'pageRegistration',
		'description' => 'Чанк формы регистрации.',
	),
);

// Save chunks for setup options
$BUILD_CHUNKS = array();

foreach ($tmp as $k => $v) {
	/* @avr modChunk $chunk */
	$chunk = $modx->newObject('modChunk');
	$chunk->fromArray(array(
		'id' => 0,
		'name' => $k,
		'description' => @$v['description'],
		'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/chunk.' . $v['file'] . '.tpl'),
		'static' => BUILD_CHUNK_STATIC,
		'source' => 1,
		'static_file' => 'core/components/' . PKG_NAME_LOWER . '/elements/chunks/chunk.' . $v['file'] . '.tpl',
	), '', true, true);

	$chunks[] = $chunk;

	$BUILD_CHUNKS[$k] = file_get_contents($sources['source_core'] . '/elements/chunks/chunk.' . $v['file'] . '.tpl');
}

unset($tmp);
return $chunks;