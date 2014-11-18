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
$items = include dirname(__FILE__) . '/modx_exerplan_gallery_mediatypes.php';
foreach ($items as $item) {
	$check = $modx->getObject('GalleryMediatypes', array(
        'mediatype' => $item['mediatype'],
    ));
    if (!$check) {
        $newObject = $modx->newObject('GalleryMediatypes');
        $newObject->fromArray(array(
            'mediatype' => $item['mediatype'],
            'description' => $item['description'],
            'file_extensions' => $item['file_extensions'],
                ), '', true, true);
        $collection[$item['mediatype']] = $newObject;
    }
}
return $collection;