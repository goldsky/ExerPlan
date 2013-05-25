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
 * Resolve creating db tables
 *
 * @package exerplan
 * @subpackage build
 */
if ($modx = & $object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            if ($modx->getDebug()) {
                $modx->log(modX::LOG_LEVEL_WARN, 'resolver xPDOTransport::ACTION_INSTALL');
            }
            $modelPath = $modx->getOption('core_path') . 'components/exerplan/model/';
            if ($modx->addPackage('exerplan', $modelPath, 'modx_exerplan_')) {
                if ($modx->getDebug()) {
                    $modx->log(modX::LOG_LEVEL_WARN, 'package was added in resolver xPDOTransport::ACTION_INSTALL');
                }
                $manager = $modx->getManager();
                $manager->createObjectContainer('Assessments');
                $manager->createObjectContainer('Galleries');
                $manager->createObjectContainer('GalleryMediatypes');
                $defaults = include $modx->getOption('core_path') . 'components/exerplan/defaults/defaults.gallery.mediatypes.php';
                foreach ($defaults as $default) {
                    $default->save();
                }
                $manager->createObjectContainer('GallerySources');
                $defaults = include $modx->getOption('core_path') . 'components/exerplan/defaults/defaults.gallery.sources.php';
                foreach ($defaults as $default) {
                    $default->save();
                }
                $manager->createObjectContainer('Levels');
                $defaults = include $modx->getOption('core_path') . 'components/exerplan/defaults/defaults.levels.php';
                foreach ($defaults as $default) {
                    $default->save();
                }
                $manager->createObjectContainer('UsergroupsWorkouts');
                $manager->createObjectContainer('UsersWorkouts');
                $manager->createObjectContainer('Workouts');
            }
            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
        case xPDOTransport::ACTION_UNINSTALL:
            if ($modx->getDebug()) {
                $modx->log(modX::LOG_LEVEL_WARN, 'resolver xPDOTransport::ACTION_UNINSTALL');
                $modelPath = $modx->getOption('core_path') . 'components/exerplan/model/';
                if ($modx->addPackage('exerplan', $modelPath, 'modx_exerplan_')) {
                    $modx->log(modX::LOG_LEVEL_WARN, 'package was added in resolver xPDOTransport::ACTION_UNINSTALL');
                }
            }
            break;
    }
}

return true;