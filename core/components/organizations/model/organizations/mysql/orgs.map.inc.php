<?php
$xpdo_meta_map['Orgs']= array (
  'package' => 'organizations',
  'version' => '1.1',
  'table' => 'orgs',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'urlico' => 1,
    'shortname' => '',
    'longname' => '',
    'description' => '',
    'inn' => '',
    'kpp' => '',
    'ogrn' => '',
    'okpo' => '',
    'ur_address' => '',
    'postal_address' => '',
    'bank_name' => '',
    'bank_bik' => '',
    'bank_sity' => '',
    'bank_rasch_acc' => '',
    'bank_kor_acc' => '',
    'logotip' => '',
    'director' => '',
    'glav_buh' => '',
    'kontragent' => '',
    'email' => '',
    'site' => '',
    'phone' => '',
    'phone_add' => '',
    'fax' => '',
    'discount' => 0.0,
    'ext_int_1' => 0,
    'ext_int_2' => 0,
    'ext_varchar_1' => '',
    'ext_varchar_2' => '',
    'ext_varchar_3' => '',
    'ext_varchar_4' => '',
    'ext_varchar_5' => '',
    'ext_varchar_6' => '',
    'ext_varchar_7' => '',
    'ext_varchar_8' => '',
    'ext_varchar_9' => '',
    'ext_varchar_10' => '',
    'ext_varchar_11' => '',
    'ext_varchar_12' => '',
    'ext_text_1' => '',
    'ext_text_2' => '',
    'ext_double_1' => 0.0,
    'ext_double_2' => 0.0,
    'debt_beznal' => 0.0,
    'debt_nal' => 0.0,
    'active' => 1,
    'buyer' => 1,
    'supplier' => 0,
    'op' => 0,
    'manager_id' => 0,
    'op_manager_id' => NULL,
    'supplier_manager_id' => NULL,
    'op_date_start' => NULL,
    'op_date_end' => NULL,
    'zhuki' => '',
    'zhuki_proc' => '',
    'zhuki_date_start' => NULL,
    'zhuki_date_end' => NULL,
    'barcode_template_id' => 1,
  ),
  'fieldMeta' => 
  array (
    'urlico' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 1,
    ),
    'shortname' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'longname' => 
    array (
      'dbtype' => 'text',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'inn' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '12',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'kpp' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '9',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ogrn' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '13',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'okpo' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '10',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ur_address' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'postal_address' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'bank_name' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'bank_bik' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '9',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'bank_sity' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'bank_rasch_acc' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'bank_kor_acc' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'logotip' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'director' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'glav_buh' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'kontragent' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'email' => 
    array (
      'dbtype' => 'text',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'site' => 
    array (
      'dbtype' => 'text',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'phone' => 
    array (
      'dbtype' => 'text',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'phone_add' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'fax' => 
    array (
      'dbtype' => 'text',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'discount' => 
    array (
      'dbtype' => 'double',
      'phptype' => 'double',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0.0,
    ),
    'ext_int_1' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'ext_int_2' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'ext_varchar_1' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_varchar_2' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_varchar_3' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_varchar_4' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_varchar_5' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_varchar_6' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_varchar_7' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_varchar_8' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_varchar_9' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_varchar_10' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_varchar_11' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_varchar_12' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_text_1' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_text_2' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ext_double_1' => 
    array (
      'dbtype' => 'double',
      'phptype' => 'double',
      'null' => true,
      'default' => 0.0,
    ),
    'ext_double_2' => 
    array (
      'dbtype' => 'double',
      'phptype' => 'double',
      'null' => true,
      'default' => 0.0,
    ),
    'debt_beznal' => 
    array (
      'dbtype' => 'double',
      'phptype' => 'double',
      'null' => true,
      'default' => 0.0,
    ),
    'debt_nal' => 
    array (
      'dbtype' => 'double',
      'phptype' => 'double',
      'null' => true,
      'default' => 0.0,
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 1,
    ),
    'buyer' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 1,
      'title' => 'Покупатель',
    ),
    'supplier' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 0,
      'title' => 'Поставщик',
    ),
    'op' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 0,
      'title' => 'Отдел продаж',
    ),
    'manager_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
      'title' => 'Менеджер Отдел сопровождения',
    ),
    'op_manager_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => true,
      'title' => 'Менеджер Отдел продаж',
    ),
    'supplier_manager_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => true,
      'title' => 'Менеджер Отдел снабжения',
    ),
    'op_date_start' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => true,
    ),
    'op_date_end' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => true,
    ),
    'zhuki' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'zhuki_proc' => 
    array (
      'dbtype' => 'text',
      'precision' => '10',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'zhuki_date_start' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => true,
    ),
    'zhuki_date_end' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => true,
    ),
    'barcode_template_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 1,
      'title' => 'Шаблон этикеток',
    ),
  ),
  'indexes' => 
  array (
    'shortname' => 
    array (
      'alias' => 'shortname',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'shortname' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'inn' => 
    array (
      'alias' => 'inn',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'inn' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'ext_int_1' => 
    array (
      'alias' => 'ext_int_1',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'ext_int_1' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'ext_int_2' => 
    array (
      'alias' => 'ext_int_2',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'ext_int_2' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'active' => 
    array (
      'alias' => 'active',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'active' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'barcode_template_id' => 
    array (
      'alias' => 'barcode_template_id',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'barcode_template_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'OrgsUsersLink' => 
    array (
      'class' => 'OrgsUsersLink',
      'local' => 'id',
      'foreign' => 'org_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'OrgsContactLink' => 
    array (
      'class' => 'OrgsContactLink',
      'local' => 'id',
      'foreign' => 'org_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
