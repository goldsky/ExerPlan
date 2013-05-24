<?php
$xpdo_meta_map['GalleryMediatypes']= array (
  'package' => 'exerplan',
  'version' => '1.1',
  'table' => 'gallery_mediatypes',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'mediatype' => NULL,
    'description' => NULL,
    'file_extensions' => NULL,
  ),
  'fieldMeta' => 
  array (
    'mediatype' => 
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
    'file_extensions' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
  ),
  'aggregates' => 
  array (
    'Galleries' => 
    array (
      'class' => 'Galleries',
      'local' => 'id',
      'foreign' => 'mediatype_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'GallerySources' => 
    array (
      'class' => 'GallerySources',
      'local' => 'id',
      'foreign' => 'mediatype_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
