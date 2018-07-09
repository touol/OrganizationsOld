<?php
$xpdo_meta_map['OrgsInvites']= array (
  'package' => 'organizations',
  'version' => '1.1',
  'table' => 'orgs_invites',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'invite_code' => NULL,
    'description' => '',
    'type' => 0,
    'org_id' => 0,
    'user_group_id' => 0,
    'email' => '',
    'email_sended' => 0,
    'fullname' => '',
    'kupon_id' => 0,
    'createdby_user_id' => 0,
    'createdon' => '0000-00-00 00:00:00',
    'date_exp' => '0000-00-00 00:00:00',
    'used_user_id' => 0,
    'used' => 0,
    'set_discount' => 0,
  ),
  'fieldMeta' => 
  array (
    'invite_code' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '120',
      'phptype' => 'text',
      'null' => false,
      'unique' => 'true',
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'text',
      'null' => true,
      'default' => '',
    ),
    'type' => 
    array (
      'dbtype' => 'int',
      'precision' => '2',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'org_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'user_group_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '6',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'email' => 
    array (
      'dbtype' => 'text',
      'precision' => '255',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'email_sended' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 0,
    ),
    'fullname' => 
    array (
      'dbtype' => 'text',
      'precision' => '255',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'kupon_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'createdby_user_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'createdon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
      'default' => '0000-00-00 00:00:00',
    ),
    'date_exp' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
      'default' => '0000-00-00 00:00:00',
    ),
    'used_user_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'used' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 0,
    ),
    'set_discount' => 
    array (
      'dbtype' => 'int',
      'precision' => '2',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
  ),
  'indexes' => 
  array (
    'invite_code' => 
    array (
      'alias' => 'invite_code',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'invite_code' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
);
