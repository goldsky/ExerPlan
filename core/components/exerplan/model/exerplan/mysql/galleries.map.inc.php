<?php
$xpdo_meta_map['Galleries']= array (
  'package' => 'exerplan',
  'version' => '1.1',
  'table' => 'galleries',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'workout_id' => NULL,
    'user_id' => NULL,
    'source_id' => 0,
    'mediatype_id' => NULL,
    'url' => NULL,
    'name' => NULL,
    'description' => NULL,
    'data' => NULL,
    'controller' => NULL,
  ),
  'fieldMeta' => 
  array (
    'workout_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'user_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'source_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'mediatype_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'url' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
    ),
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'data' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'controller' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
  ),
  'aggregates' => 
  array (
    'GallerySources' => 
    array (
      'class' => 'GallerySources',
      'local' => 'source_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Workouts' => 
    array (
      'class' => 'Workouts',
      'local' => 'workout_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'User' => 
    array (
      'class' => 'modUser',
      'local' => 'user_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'GalleryMediatypes' => 
    array (
      'class' => 'GalleryMediatypes',
      'local' => 'mediatype_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
