<?php

/**
 * ExerPlan
 *
 * Copyright 2013 by goldsky <goldsky@virtudraft.com>
 *
 * This file is part of ExerPlan, a health training and clinics system for MODX
 * Revolution.
 *
 * ExerPlan is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation version 3,
 *
 * ExerPlan is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ExerPlan; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * ExerPlan build script
 *
 * @package exerplan
 * @subpackage build
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

/* define version */
define('PKG_NAME', 'ExerPlan');
define('PKG_NAME_LOWER', 'exerplan');
define('PKG_VERSION', '1.0.0');
define('PKG_RELEASE', 'pl');

/* override with your own defines here (see build.config.sample.php) */
require_once dirname(__FILE__) . '/build.config.php';
require_once realpath(MODX_CORE_PATH) . '/model/modx/modx.class.php';

/* define sources */
$root = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR;
$sources = array(
    'root' => $root,
    'build' => BUILD_PATH,
    'resolvers' => realpath(BUILD_PATH . 'resolvers/') . DIRECTORY_SEPARATOR,
    'validators' => realpath(BUILD_PATH . 'validators/') . DIRECTORY_SEPARATOR,
    'data' => realpath(BUILD_PATH . 'data') . DIRECTORY_SEPARATOR,
    'properties' => realpath(BUILD_PATH . 'data/properties/') . DIRECTORY_SEPARATOR,
    'source_core' => realpath(MODX_CORE_PATH . 'components') . DIRECTORY_SEPARATOR . PKG_NAME_LOWER,
    'source_assets' => realpath(MODX_ASSETS_PATH . 'components') . DIRECTORY_SEPARATOR . PKG_NAME_LOWER,
    'docs' => realpath(MODX_CORE_PATH . 'components/' . PKG_NAME_LOWER . '/docs/') . DIRECTORY_SEPARATOR,
    'lexicon' => realpath(MODX_CORE_PATH . 'components/' . PKG_NAME_LOWER . '/lexicon/') . DIRECTORY_SEPARATOR,
);
unset($root);

$modx = new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');
echo '<pre>';

$modx->loadClass('transport.modPackageBuilder', '', false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER, false, true, '{core_path}components/' . PKG_NAME_LOWER . '/');

/**
 * MENU & ACTION
 */
$menu = include $sources['data'] . 'transport.menu.php';
if (empty($menu)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in menu.');
} else {
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaging in menu...');
    $menuVehicle = $builder->createVehicle($menu, array(
        xPDOTransport::PRESERVE_KEYS => true,
        xPDOTransport::UPDATE_OBJECT => true,
        xPDOTransport::UNIQUE_KEY => 'text',
        xPDOTransport::RELATED_OBJECTS => true,
        xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array(
            'Action' => array(
                xPDOTransport::PRESERVE_KEYS => false,
                xPDOTransport::UPDATE_OBJECT => true,
                xPDOTransport::UNIQUE_KEY => array('namespace', 'controller'),
            ),
        ),
    ));
    $modx->log(modX::LOG_LEVEL_INFO, 'Adding in Menu & Action done.');
    $builder->putVehicle($menuVehicle);
    unset($menuVehicle, $menu);
}

/**
 * SYSTEM SETTINGS
 */
$settings = include $sources['data'] . 'transport.settings.php';
if (!is_array($settings)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in settings.');
} else {
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaging in System Settings...');
    $settingAttributes = array(
        xPDOTransport::UNIQUE_KEY => 'key',
        xPDOTransport::PRESERVE_KEYS => true,
        xPDOTransport::UPDATE_OBJECT => false,
    );
    foreach ($settings as $setting) {
        $settingVehicle = $builder->createVehicle($setting, $settingAttributes);
        $builder->putVehicle($settingVehicle);
    }
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($settings) . ' System Settings done.');
    unset($settingVehicle, $settings, $setting, $settingAttributes);
}

/**
 * CATEGORY
 */
$category = $modx->newObject('modCategory');
$category->set('id', 1);
$category->set('category', 'ExerPlan');

/**
 * SNIPPETS
 */
$snippets = include $sources['data'] . 'transport.snippets.php';
if (is_array($snippets)) {
    $modx->log(modX::LOG_LEVEL_INFO, 'Adding in snippets.');
    $category->addMany($snippets);
    $modx->log(modX::LOG_LEVEL_INFO, 'Adding in snippets done.');
} else {
    $modx->log(modX::LOG_LEVEL_FATAL, 'Adding snippets failed.');
}

$elementsAttribute = array(
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array(
        'Snippets' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
    )
);

$elementsVehicle = $builder->createVehicle($category, $elementsAttribute);

/**
 * FILE RESOLVERS
 */
$modx->log(modX::LOG_LEVEL_INFO, 'Adding in files...');
$elementsVehicle->resolve('file', array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));
$elementsVehicle->resolve('file', array(
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';",
));
$modx->log(modX::LOG_LEVEL_INFO, 'Adding in files done.');

/**
 * RESOLVERS
 */
$modx->log(modX::LOG_LEVEL_INFO, 'Adding in PHP resolvers...');
$elementsVehicle->resolve('php', array(
    'source' => $sources['resolvers'] . 'tables.resolver.php',
));
$modx->log(modX::LOG_LEVEL_INFO, 'Adding in PHP resolvers done.');

/**
 * VALIDATORS
 */
$modx->log(modX::LOG_LEVEL_INFO, 'Adding in PHP validators...');
$elementsVehicle->validate('php', array(
    'source' => $sources['validators'] . 'tables.validator.php',
));
$modx->log(modX::LOG_LEVEL_INFO, 'Adding in PHP validators done.');

$builder->putVehicle($elementsVehicle);
unset($elementsVehicle);
$modx->log(modX::LOG_LEVEL_INFO, 'Packaged in Elements done.');
flush();

/**
 * PRE-MADE DATA
 * *************************************************************************** */
$modx->log(modX::LOG_LEVEL_INFO, 'Adding in Default contents ...');
$modelPath = $modx->getOption('core_path') . 'components/exerplan/model/';
$modelPath = realpath($modelPath) . DIRECTORY_SEPARATOR;
$modx->addPackage('exerplan', $modelPath, 'modx_exerplan_');
/* * *************************************************************************** */
$items = include $sources['data'] . 'transport.levels.php';
if (!is_array($items)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in levels.');
} else {
    $dataAttributes = array(
        xPDOTransport::UNIQUE_KEY => 'level',
        xPDOTransport::PRESERVE_KEYS => true,
        xPDOTransport::UPDATE_OBJECT => false,
    );
    foreach ($items as $item) {
        $dataVehicle = $builder->createVehicle($item, $dataAttributes);
        $builder->putVehicle($dataVehicle);
    }
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($items) . ' levels.');
    unset($dataVehicle, $items, $item, $dataAttributes);
}
$items = include $sources['data'] . 'transport.gallery.mediatypes.php';
if (!is_array($items)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in media types.');
} else {
    $dataAttributes = array(
        xPDOTransport::UNIQUE_KEY => 'mediatype',
        xPDOTransport::PRESERVE_KEYS => true,
        xPDOTransport::UPDATE_OBJECT => false,
    );
    foreach ($items as $item) {
        $dataVehicle = $builder->createVehicle($item, $dataAttributes);
        $builder->putVehicle($dataVehicle);
    }
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($items) . ' media types.');
    unset($dataVehicle, $items, $item, $dataAttributes);
}
$items = include $sources['data'] . 'transport.gallery.sources.php';
if (!is_array($items)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in media sources.');
} else {
    $dataAttributes = array(
        xPDOTransport::UNIQUE_KEY => 'source',
        xPDOTransport::PRESERVE_KEYS => true,
        xPDOTransport::UPDATE_OBJECT => false,
    );
    foreach ($items as $item) {
        $dataVehicle = $builder->createVehicle($item, $dataAttributes);
        $builder->putVehicle($dataVehicle);
    }
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($items) . ' media sources.');
    unset($dataVehicle, $items, $item, $dataAttributes);
}
$modx->log(modX::LOG_LEVEL_INFO, 'Adding in Default contents done.');
flush();
/* * *************************************************************************** */

/**
 * license file, readme and setup options
 */
$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
));

$builder->pack();

$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tend = $mtime;
$totalTime = ($tend - $tstart);
$totalTime = sprintf("%2.4f s", $totalTime);

$modx->log(modX::LOG_LEVEL_INFO, "\n<br />" . PKG_NAME . " package was built.<br />\nExecution time: {$totalTime}\n");

exit();