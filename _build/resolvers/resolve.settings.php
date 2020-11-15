<?php

if ($object->xpdo) {
    /** @var modX $modx */
    $modx =& $object->xpdo;
    /** @var array $options */
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('organizations.core_path', null,
                    $modx->getOption('core_path') . 'components/organizations/') . 'model/';
            $modx->addPackage('organizations', $modelPath);
            $lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;
			$modx->log(modX::LOG_LEVEL_INFO, 'Updated settings start');
			$val1 =array (
					  0 => 
					  array (
						'id' => 1,
						'name' => 'shortname',
						'label' => 'Имя организации',
						'rank' => '0',
						'xtype' => 'org-combo-dadata',
						'column' => '0',
						'active' => true,
					  ),
					  1 => 
					  array (
						'id' => 25,
						'name' => 'manager_id',
						'label' => 'Менеджер',
						'rank' => '1',
						'xtype' => 'manager-combo',
						'column' => '1',
						'active' => true,
					  ),
					  2 => 
					  array (
						'id' => 24,
						'name' => 'discount',
						'label' => 'Скидка',
						'rank' => '2',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => true,
					  ),
					  3 => 
					  array (
						'id' => 26,
						'name' => 'active',
						'label' => 'Включена',
						'rank' => '3',
						'xtype' => 'xcheckbox',
						'active' => true,
						'column' => '1',
					  ),
					  4 => 
					  array (
						'id' => 2,
						'name' => 'longname',
						'label' => 'Полное имя',
						'rank' => '4',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => true,
					  ),
					  5 => 
					  array (
						'id' => 19,
						'name' => 'email',
						'label' => 'Электронная почта',
						'rank' => '7',
						'xtype' => 'email-combo-dadata',
						'column' => '1',
						'active' => false,
					  ),
					  6 => 
					  array (
						'id' => 20,
						'name' => 'site',
						'label' => 'Сайт',
						'rank' => '8',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => false,
					  ),
					  7 => 
					  array (
						'id' => 15,
						'name' => 'logotip',
						'label' => 'Логотип',
						'rank' => '9',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => false,
					  ),
					  8 => 
					  array (
						'id' => 23,
						'name' => 'fax',
						'label' => 'Факс',
						'rank' => '10',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => false,
					  ),
					  9 => 
					  array (
						'id' => 3,
						'name' => 'description',
						'label' => 'Описание',
						'rank' => '11',
						'xtype' => 'textarea',
						'column' => '1',
						'active' => false,
					  ),
					  10 => 
					  array (
						'id' => 22,
						'name' => 'phone_add',
						'label' => 'Доп. телефоны ',
						'rank' => '12',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => false,
					  ),
					  11 => 
					  array (
						'id' => 21,
						'name' => 'phone',
						'label' => 'Телефон',
						'rank' => '13',
						'xtype' => 'textfield',
						'column' => '1',
						'active' => false,
					  ),
					  12 => 
					  array (
						'id' => 4,
						'name' => 'inn',
						'label' => 'ИНН',
						'rank' => '15',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => true,
					  ),
					  13 => 
					  array (
						'id' => 5,
						'name' => 'kpp',
						'label' => 'КПП',
						'rank' => '16',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => true,
					  ),
					  14 => 
					  array (
						'id' => 6,
						'name' => 'ogrn',
						'label' => 'ОГРН',
						'rank' => '16',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => true,
					  ),
					  15 => 
					  array (
						'id' => 7,
						'name' => 'okpo',
						'label' => 'ОКПО',
						'rank' => '17',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  16 => 
					  array (
						'id' => 8,
						'name' => 'ur_address',
						'label' => 'Юридический адрес',
						'rank' => '18',
						'xtype' => 'addr-combo-dadata',
						'column' => '2',
						'active' => true,
					  ),
					  17 => 
					  array (
						'id' => 9,
						'name' => 'postal_address',
						'label' => 'Почтовый адресс',
						'rank' => '19',
						'xtype' => 'addr-combo-dadata',
						'column' => '2',
						'active' => false,
					  ),
					  18 => 
					  array (
						'id' => 10,
						'name' => 'bank_name',
						'label' => 'Имя банка',
						'rank' => '23',
						'xtype' => 'bank-combo-dadata',
						'column' => '3',
						'active' => true,
					  ),
					  19 => 
					  array (
						'id' => 12,
						'name' => 'bank_sity',
						'label' => 'Город банка',
						'rank' => '24',
						'xtype' => 'textfield',
						'column' => '3',
						'active' => true,
					  ),
					  20 => 
					  array (
						'id' => 11,
						'name' => 'bank_bik',
						'label' => 'БИК',
						'rank' => '25',
						'xtype' => 'textfield',
						'column' => '3',
						'active' => true,
					  ),
					  21 => 
					  array (
						'id' => 13,
						'name' => 'bank_rasch_acc',
						'label' => 'Расчетный счет',
						'rank' => '26',
						'xtype' => 'textfield',
						'column' => '3',
						'active' => true,
					  ),
					  22 => 
					  array (
						'id' => 14,
						'name' => 'bank_kor_acc',
						'label' => 'Кореспонд. счет',
						'rank' => '27',
						'xtype' => 'textfield',
						'column' => '3',
						'active' => true,
					  ),
					  23 => 
					  array (
						'id' => 16,
						'name' => 'director',
						'label' => 'Директор',
						'rank' => '28',
						'xtype' => 'fio-combo-dadata',
						'column' => '2',
						'active' => true,
					  ),
					  24 => 
					  array (
						'id' => 17,
						'name' => 'glav_buh',
						'label' => 'Главный бухгалтер',
						'rank' => '29',
						'xtype' => 'fio-combo-dadata',
						'column' => '2',
						'active' => false,
					  ),
					  25 => 
					  array (
						'id' => 18,
						'name' => 'kontragent',
						'label' => 'Имя контрагента',
						'rank' => '30',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  26 => 
					  array (
						'id' => 40,
						'name' => 'ext_int_1',
						'label' => 'ext_int_1',
						'rank' => '31',
						'xtype' => 'numberfield',
						'column' => '2',
						'active' => false,
					  ),
					  27 => 
					  array (
						'id' => 41,
						'name' => 'ext_int_2',
						'label' => 'ext_int_2',
						'rank' => '32',
						'xtype' => 'numberfield',
						'column' => '2',
						'active' => false,
					  ),
					  28 => 
					  array (
						'id' => 42,
						'name' => 'ext_varchar_1',
						'label' => 'ext_varchar_1',
						'rank' => '33',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  29 => 
					  array (
						'id' => 43,
						'name' => 'ext_varchar_2',
						'label' => 'ext_varchar_2',
						'rank' => '34',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  30 => 
					  array (
						'id' => 44,
						'name' => 'ext_varchar_3',
						'label' => 'ext_varchar_3',
						'rank' => '35',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  31 => 
					  array (
						'id' => 45,
						'name' => 'ext_varchar_4',
						'label' => 'ext_varchar_4',
						'rank' => '36',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  32 => 
					  array (
						'id' => 46,
						'name' => 'ext_varchar_5',
						'label' => 'ext_varchar_5',
						'rank' => '37',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  33 => 
					  array (
						'id' => 47,
						'name' => 'ext_varchar_6',
						'label' => 'ext_varchar_6',
						'rank' => '38',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  34 => 
					  array (
						'id' => 48,
						'name' => 'ext_varchar_7',
						'label' => 'ext_varchar_7',
						'rank' => '39',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  35 => 
					  array (
						'id' => 49,
						'name' => 'ext_varchar_8',
						'label' => 'ext_varchar_8',
						'rank' => '40',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  36 => 
					  array (
						'id' => 50,
						'name' => 'ext_varchar_9',
						'label' => 'ext_varchar_9',
						'rank' => '41',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  37 => 
					  array (
						'id' => 51,
						'name' => 'ext_varchar_10',
						'label' => 'ext_varchar_10',
						'rank' => '42',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  38 => 
					  array (
						'id' => 52,
						'name' => 'ext_varchar_11',
						'label' => 'ext_varchar_11',
						'rank' => '43',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  39 => 
					  array (
						'id' => 53,
						'name' => 'ext_varchar_12',
						'label' => 'ext_varchar_12',
						'rank' => '44',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => false,
					  ),
					  40 => 
					  array (
						'id' => 60,
						'name' => 'ext_text_1',
						'label' => 'ext_text_1',
						'rank' => '45',
						'xtype' => 'textarea',
						'column' => '2',
						'active' => false,
					  ),
					  41 => 
					  array (
						'id' => 61,
						'name' => 'ext_text_2',
						'label' => 'ext_text_2',
						'rank' => '46',
						'xtype' => 'textarea',
						'column' => '2',
						'active' => false,
					  ),
					  42 => 
					  array (
						'id' => 80,
						'name' => 'ext_double_1',
						'label' => 'ext_double_1',
						'rank' => '47',
						'xtype' => 'textfield',
						'column' => '3',
						'active' => false,
					  ),
					  43 => 
					  array (
						'id' => 81,
						'name' => 'ext_double_2',
						'label' => 'ext_double_2',
						'rank' => '48',
						'xtype' => 'textfield',
						'column' => '3',
						'active' => false,
					  ),
					  44 => 
					  array (
						'id' => 82,
						'name' => 'debt_beznal',
						'label' => 'задолжность безнал',
						'rank' => '49',
						'xtype' => 'textfield',
						'column' => '3',
						'active' => false,
					  ),
					  45 => 
					  array (
						'id' => 83,
						'name' => 'debt_nal',
						'label' => 'задолжность  нал',
						'rank' => '50',
						'xtype' => 'textfield',
						'column' => '3',
						'active' => false,
					  ),
					  46 => 
					  array (
						'id' => 90,
						'name' => 'op_manager_id',
						'label' => 'Менеджер ОП',
						'rank' => '51',
						'xtype' => 'op-manager-combo',
						'column' => '1',
						'active' => true,
					  ),
					  47 => 
					  array (
						'id' => 91,
						'name' => 'op_date_start',
						'label' => 'МОП дата старт',
						'rank' => '52',
						'xtype' => 'datefield',
						'column' => '1',
						'active' => true,
					  ),
					  48 => 
					  array (
						'id' => 92,
						'name' => 'op_date_end',
						'label' => 'МОП дата конец',
						'rank' => '53',
						'xtype' => 'datefield',
						'column' => '1',
						'active' => true,
					  ),
					  49 =>
					  array (
						'id' => 100,
						'name' => 'zhuki',
						'label' => 'Жуки',
						'rank' => '54',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => true,
					  ),
					  50 => 
					  array (
						'id' => 101,
						'name' => 'zhuki_proc',
						'label' => 'Жуки процент',
						'rank' => '55',
						'xtype' => 'textfield',
						'column' => '2',
						'active' => true,
					  ),
					  51 => 
					  array (
						'id' => 102,
						'name' => 'zhuki_date_start',
						'label' => 'Жуки дата старт',
						'rank' => '56',
						'xtype' => 'datefield',
						'column' => '2',
						'active' => true,
					  ),
					  52 => 
					  array (
						'id' => 103,
						'name' => 'zhuki_date_end',
						'label' => 'Жуки дата конец',
						'rank' => '57',
						'xtype' => 'datefield',
						'column' => '2',
						'active' => true,
					  ),
					);
			$val2 = array (
				  0 => 
				  array (
					'name' => 'edit_org_data',
					'label' => 'Редактирование данных организации',
					'id' => 7,
				  ),
				  1 => 
				  array (
					'name' => 'view_price',
					'label' => 'Просмотр цен в расчетах',
					'id' => 8,
				  ),
				  2 => 
				  array (
					'name' => 'order_send',
					'label' => 'Право на оформление и отправку заказов',
					'id' => 9,
				  ),
				  3 => 
				  array (
					'name' => 'order_view',
					'label' => 'Право на просмотр заказов',
					'id' => 10,
				  ),
				  4 => 
				  array (
					'name' => 'view_owner_raschet',
					'label' => 'Право на просмотр и редактирование собственных расчетов',
					'id' => 11,
				  ),
				  5 => 
				  array (
					'name' => 'view_all_raschet',
					'label' => 'Право на просмотр и редактирование всех расчетов',
					'id' => 12,
				  ),
				  6 => 
				  array (
					'name' => 'raschet_new',
					'label' => 'Создание нового расчета',
					'id' => 13,
				  ),
				  7 => 
				  array (
					'name' => 'list_org_users',
					'label' => 'Права на просмотр списка пользователей',
					'id' => 14,
				  ),
				);
				
            $configs = array(
                '2' => array(
                    //'name' => !$lang ? 'Новый' : 'New',
                    'setting' => 'org_fields',
					'value' => json_encode($val1),
					'xtype' => 'array',
                ),
				'3' => array(
                    'setting' => 'org_access',
					'value' => json_encode($val2),
					'xtype' => 'array',
                ),
            );
            foreach ($configs as $id => $properties) {
                if (!$config = $modx->getCount('OrgsConfig', array('setting' => $properties['setting']))) {
                    $config = $modx->newObject('OrgsConfig', $properties);
                    //$config->set('id', $id);
                    $config->save();
					$modx->log(modX::LOG_LEVEL_INFO, 'New OrgsConfig "<b>' . $properties['setting'] . '</b>"');
                }else{
					if($config = $modx->getObject('OrgsConfig', array('setting' => $properties['setting']))){
						$old_config = json_decode($config->value,1);
						$new_config = json_decode($properties['value'],1);
						foreach($new_config as $k=>$new_v){
							foreach($old_config as $old_v){
								if($new_v['id'] == $old_v['id']){
									$new_config[$k] = $old_v;
								}
							}
						}
						$config->value = json_encode($new_config);
						$config->save();
					}
				}
            }
			/*if($config = $modx->getObject('OrgsConfig', 2)){
				$config->value = $configs['2']['value'];
				$config->save();
			}*/
			$groups = array (
				1 => array (
						  'name' => 'Администраторы',
						  'description' => '',
						  'data' => '{"edit_org_data":true,"view_price":true,"order_send":true,"order_view":true,"view_owner_raschet":true,"view_all_raschet":true,"raschet_new":true,"list_org_users":true}',
						),
				3 => array (
						  'name' => 'Менеджеры',
						  'description' => '',
						  'data' => '{"view_price":true,"order_send":true,"order_view":true,"view_owner_raschet":true,"view_all_raschet":true,"raschet_new":true}',
						),
				4 => array (
						  'name' => 'Инженеры',
						  'description' => '',
						  'data' => '{"view_owner_raschet":true,"raschet_new":true}',
						)
			);
			foreach ($groups as $id => $properties) {
                if (!$config = $modx->getCount('OrgsUsersGroups', array('id' => $id))) {
                    $config = $modx->newObject('OrgsUsersGroups', $properties);
                    $config->set('id', $id);
                    $config->save();
					$modx->log(modX::LOG_LEVEL_INFO, 'Updated OrgsUsersGroups "<b>' . $id . '</b>"');
                }
            }
			$modx->log(modX::LOG_LEVEL_INFO, 'Updated settings end');
            break;
        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}
return true;