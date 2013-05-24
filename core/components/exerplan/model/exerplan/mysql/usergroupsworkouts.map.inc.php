<?php
$xpdo_meta_map['UsergroupsWorkouts']= array (
  'package' => 'exerplan',
  'version' => '1.1',
  'table' => 'usergroups_workouts',
  'extends' => 'xPDOObject',
  'fields' => 
  array (
    'usergroup_id' => NULL,
    'workout_id' => NULL,
    'sort' => 0,
  ),
  'fieldMeta' => 
  array (
    'usergroup_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'pk',
    ),
    'workout_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'pk',
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
  'indexes' => 
  array (
    'PRIMARY' => 
    array (
      'alias' => 'PRIMARY',
      'primary' => true,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'workout_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
        'usergroup_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Workouts' => 
    array (
      'class' => 'Workouts',
      'local' => 'workout_id',
      'foreign' => 'id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'UserGroup' => 
    array (
      'class' => 'modUserGroup',
      'local' => 'usergroup_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
