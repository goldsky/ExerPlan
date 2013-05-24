<?php
$xpdo_meta_map['Workouts']= array (
  'package' => 'exerplan',
  'version' => '1.1',
  'table' => 'workouts',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => NULL,
    'description' => NULL,
    'goal' => NULL,
    'level_id' => NULL,
    'set' => 1,
    'repetition' => 1,
    'rest_time' => NULL,
    'rest_time_unit' => NULL,
    'mon' => NULL,
    'tue' => NULL,
    'wed' => NULL,
    'thu' => NULL,
    'fri' => NULL,
    'sat' => NULL,
    'sun' => NULL,
    'timely_rep' => NULL,
    'timely_unit' => NULL,
    'sort' => 0,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'goal' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'level_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
    ),
    'set' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 1,
    ),
    'repetition' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 1,
    ),
    'rest_time' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'rest_time_unit' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '50',
      'phptype' => 'string',
      'null' => true,
    ),
    'mon' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'tue' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'wed' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'thu' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'fri' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'sat' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'sun' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'timely_rep' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '2',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'timely_unit' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '50',
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
  'composites' => 
  array (
    'Galleries' => 
    array (
      'class' => 'Galleries',
      'local' => 'id',
      'foreign' => 'workout_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'UsergroupsWorkouts' => 
    array (
      'class' => 'UsergroupsWorkouts',
      'local' => 'id',
      'foreign' => 'workout_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'UsersWorkouts' => 
    array (
      'class' => 'UsersWorkouts',
      'local' => 'id',
      'foreign' => 'workout_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'Levels' => 
    array (
      'class' => 'Levels',
      'local' => 'level_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
