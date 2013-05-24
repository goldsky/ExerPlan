<?php
$xpdo_meta_map['Levels']= array (
  'package' => 'exerplan',
  'version' => '1.1',
  'table' => 'levels',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'level' => NULL,
    'description' => NULL,
    'sort' => 0,
  ),
  'fieldMeta' => 
  array (
    'level' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '50',
      'phptype' => 'string',
      'null' => false,
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'sort' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
  'aggregates' => 
  array (
    'Workouts' => 
    array (
      'class' => 'Workouts',
      'local' => 'id',
      'foreign' => 'level_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
