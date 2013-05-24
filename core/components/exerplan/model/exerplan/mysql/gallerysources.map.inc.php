<?php
$xpdo_meta_map['GallerySources']= array (
  'package' => 'exerplan',
  'version' => '1.1',
  'table' => 'gallery_sources',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'source' => NULL,
    'mediatype_id' => NULL,
    'description' => NULL,
    'data' => NULL,
    'controller' => NULL,
  ),
  'fieldMeta' => 
  array (
    'source' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
    ),
    'mediatype_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
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
  'composites' => 
  array (
    'Galleries' => 
    array (
      'class' => 'Galleries',
      'local' => 'id',
      'foreign' => 'source_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
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
