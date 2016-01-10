<?php
$xpdo_meta_map['Orgs']= array (
  'package' => 'organizations',
  'version' => '1.1',
  'table' => 'orgs',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
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
    'discount' => 0,
    'manager_id' => 0,
    'active' => 1,
  ),
  'fieldMeta' => 
  array (
    'shortname' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'longname' => 
    array (
      'dbtype' => 'text',
      'precision' => '255',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'text',
      'null' => true,
      'default' => '',
    ),
    'inn' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '12',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'kpp' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '9',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'ogrn' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '13',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'okpo' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '10',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'ur_address' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'postal_address' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'bank_name' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'bank_bik' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '9',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'bank_sity' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'bank_rasch_acc' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'bank_kor_acc' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'logotip' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'director' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'glav_buh' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'kontragent' => 
    array (
      'dbtype' => 'text',
      'precision' => '300',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'email' => 
    array (
      'dbtype' => 'text',
      'precision' => '255',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'site' => 
    array (
      'dbtype' => 'text',
      'precision' => '255',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'phone' => 
    array (
      'dbtype' => 'text',
      'precision' => '255',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'phone_add' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'fax' => 
    array (
      'dbtype' => 'text',
      'precision' => '255',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'discount' => 
    array (
      'dbtype' => 'int',
      'precision' => '2',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'manager_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 1,
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
  ),
);
