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
 * @package exerplan
 * @subpackage build
 */

$settings['exerplan.core_path'] = $modx->newObject('modSystemSetting');
$settings['exerplan.core_path']->fromArray(array(
    'key' => 'exerplan.core_path',
    'value' => '{core_path}components/exerplan/',
    'xtype' => 'textfield',
    'namespace' => 'exerplan',
    'area' => 'URL',
        ), '', true, true);

$settings['exerplan.assets_url'] = $modx->newObject('modSystemSetting');
$settings['exerplan.assets_url']->fromArray(array(
    'key' => 'exerplan.assets_url',
    'value' => '{assets_url}components/exerplan/',
    'xtype' => 'textfield',
    'namespace' => 'exerplan',
    'area' => 'URL',
        ), '', true, true);

return $settings;