<?php
$xpdo_meta_map['Assessments']= array (
  'package' => 'exerplan',
  'version' => '1.1',
  'table' => 'assessments',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'assessment' => NULL,
    'created_by' => NULL,
    'created_for' => NULL,
    'created_on' => NULL,
    'is_hidden' => 0,
  ),
  'fieldMeta' => 
  array (
    'assessment' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'created_by' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
    ),
    'created_for' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
    ),
    'created_on' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
    ),
    'is_hidden' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
  'aggregates' => 
  array (
    'Assessor' => 
    array (
      'class' => 'modUser',
      'local' => 'user_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Assessee' => 
    array (
      'class' => 'modUser',
      'local' => 'user_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
