<?php
$xpdo_meta_map['OrgsContact']= array (
  'package' => 'organizations',
  'version' => '1.1',
  'table' => 'orgs_contacts',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'email' => '',
    'name' => '',
    'shortname' => '',
    'phone' => '',
    'active' => 1,
  ),
  'fieldMeta' => 
  array (
    'email' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '120',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '120',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'shortname' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '20',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'phone' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '30',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 1,
    ),
  ),
  'indexes' => 
  array (
    'email' => 
    array (
      'alias' => 'email',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'email' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
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
    'phone' => 
    array (
      'alias' => 'phone',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'phone' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'OrgsContactLink' => 
    array (
      'class' => 'OrgsContactLink',
      'local' => 'id',
      'foreign' => 'contact_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
