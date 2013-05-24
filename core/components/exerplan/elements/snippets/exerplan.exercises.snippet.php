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
 * @subpackage snippet
 */

$scriptProperties['requireAuth'] = $modx->getOption('requireAuth', $scriptProperties, 1);
if ($scriptProperties['requireAuth']) {
    if (!$modx->user->isAuthenticated()) {
        return;
    }
}

$scriptProperties['userId'] = $modx->getOption('userId', $scriptProperties);
$scriptProperties['sortby'] = $modx->getOption('sortby', $scriptProperties, 'id');
$scriptProperties['sortdir'] = $modx->getOption('sortdir', $scriptProperties, 'asc');
$scriptProperties['phsPrefix'] = $modx->getOption('phsPrefix', $scriptProperties, 'exerplan.');
$scriptProperties['groupByUsergroups'] = $modx->getOption('groupByUsergroups', $scriptProperties);
$scriptProperties['getGalleries'] = $modx->getOption('getGalleries', $scriptProperties);
$scriptProperties['gallerySource'] = $modx->getOption('gallerySource', $scriptProperties);
$scriptProperties['galleryMediatype'] = $modx->getOption('galleryMediatype', $scriptProperties);
$scriptProperties['galleryPrefix'] = $modx->getOption('galleryPrefix', $scriptProperties, 'gallery.');

$getUsergroupWorkouts = $modx->getOption('getUsergroupWorkouts', $scriptProperties, 1);
$getUserWorkouts = $modx->getOption('getUserWorkouts', $scriptProperties, 1);
$tplItem = $modx->getOption('tplItem', $scriptProperties, 'exerplan.exercises.item');
$itemSeparator = $modx->getOption('itemSeparator', $scriptProperties, "\n");
$tplWrapper = $modx->getOption('tplWrapper', $scriptProperties, 'exerplan.exercises.wrapper');
$tplGalleryItem = $modx->getOption('tplGalleryItem', $scriptProperties, 'exerplan.gallery.item');
$gallerySeparator = $modx->getOption('gallerySeparator', $scriptProperties, "\n");
$tplGalleryWrapper = $modx->getOption('tplGalleryWrapper', $scriptProperties, 'exerplan.gallery.wrapper');

$defaultExerPlanCorePath = $modx->getOption('core_path') . 'components/exerplan/';
$exerplanCorePath = $modx->getOption('exerplan.core_path', null, $defaultExerPlanCorePath);
$exerplan = $modx->getService('exerplan', 'ExerPlan', $exerplanCorePath . 'model/', $scriptProperties);

if (!($exerplan instanceof ExerPlan)) {
    return;
}
$exerplan->setConfigs($scriptProperties);

$usergroupWorkoutsArray = array();
if (intval($getUsergroupWorkouts) === 1) {
    $usergroupWorkoutsArray = $exerplan->usergroupWorkouts();
}
$userWorkoutsArray = array();
if (intval($getUserWorkouts) === 1) {
    $userWorkoutsArray = $exerplan->userWorkouts();
}

$output = '';
//test
//$toArray = 1;
//$getGalleries = 1;

$workoutsArray = array_merge($usergroupWorkoutsArray, $userWorkoutsArray);

if (!empty($toArray)) {
    $output = '<pre>' . print_r($workoutsArray, TRUE) . '</pre>';
} else {
    $outputArray = array();
    foreach ($workoutsArray as $workout) {
        $galleries = $workout[$scriptProperties['phsPrefix'] . 'galleries'];
        if (!empty($galleries)) {
            $galleriesArray = array();
            foreach ($galleries as $gallery) {
                $galleryItemOutput = $exerplan->parseTpl($tplGalleryItem, $gallery);
                $galleryItemOutput = $exerplan->processElementTags($galleryItemOutput);
                $galleriesArray[] = $galleryItemOutput;
            }
            $galleriesString = @implode($gallerySeparator, $galleriesArray);
            $galleryWrapper = array(
                $scriptProperties['phsPrefix'] . $scriptProperties['galleryPrefix'] . 'items' => $galleriesString
            );
            $galleriesOutput = $exerplan->parseTpl($tplGalleryWrapper, $galleryWrapper);
            $galleriesOutput = $exerplan->processElementTags($galleriesOutput);
            $workout[$scriptProperties['phsPrefix'] . 'galleries'] = $galleriesOutput;
        } else {
            $workout[$scriptProperties['phsPrefix'] . 'galleries'] = '';
        }
        $itemOutput = $exerplan->parseTpl($tplItem, $workout);
        $itemOutput = $exerplan->processElementTags($itemOutput);
        $outputArray[] = $itemOutput;
    }
    $outputString = @implode($itemSeparator, $outputArray);
    $wrapper = array(
        $scriptProperties['phsPrefix'] . 'items' => $outputString
    );
    $wrapperOutput = $exerplan->parseTpl($tplWrapper, $wrapper);
    $wrapperOutput = $exerplan->processElementTags($wrapperOutput);
    $output = $wrapperOutput;
}
if (!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $output);
    return;
}

return $output;