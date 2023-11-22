<?php
$xpdo_meta_map['OrgsContactManager']= array (
  'package' => 'organizations',
  'version' => '1.1',
  'table' => 'orgs_contact_managers',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'manager_id' => NULL,
    'phone' => '',
  ),
  'fieldMeta' => 
  array (
    'manager_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
    ),
    'phone' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '12',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
  ),
);
