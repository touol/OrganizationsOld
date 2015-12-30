<?php
$xpdo_meta_map['OrgsConfig']= array (
  'package' => 'organizations',
  'version' => '1.1',
  'table' => 'orgs_config',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'setting' => '',
    'value' => NULL,
    'xtype' => '',
  ),
  'fieldMeta' => 
  array (
    'setting' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '15',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'value' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'xtype' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '15',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
  ),
);
