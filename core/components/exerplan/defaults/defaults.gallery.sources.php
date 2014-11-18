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

$collection = array();
$items = include dirname(__FILE__) . '/modx_exerplan_gallery_sources.php';
foreach ($items as $item) {
	$check = $modx->getObject('GallerySources', array(
        'source' => $item['source'],
    ));
    if (!$check) {
        $newObject = $modx->newObject('GallerySources');
        $newObject->fromArray(array(
            'source' => $item['source'],
            'mediatype_id' => $item['mediatype_id'],
            'description' => $item['description'],
            'data' => $item['data'],
            'controller' => $item['controller'],
                ), '', true, true);
        $collection[$item['source']] = $newObject;
    }
}
return $collection;