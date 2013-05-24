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

$scriptProperties['assesseeId'] = $modx->getOption('assesseeId', $scriptProperties);
$scriptProperties['assessorId'] = $modx->getOption('assessorId', $scriptProperties);
$scriptProperties['showHidden'] = $modx->getOption('showHidden', $scriptProperties);
$scriptProperties['sortby'] = $modx->getOption('sortby', $scriptProperties, 'id');
$scriptProperties['sortdir'] = $modx->getOption('sortdir', $scriptProperties, 'desc');
$scriptProperties['phsPrefix'] = $modx->getOption('phsPrefix', $scriptProperties, 'exerplan.');
$scriptProperties['assessmentPrefix'] = $modx->getOption('assessmentPrefix', $scriptProperties, 'assessment.');

$tplItem = $modx->getOption('tplItem', $scriptProperties, 'exerplan.assessment.item');
$itemSeparator = $modx->getOption('itemSeparator', $scriptProperties, "\n");
$tplWrapper = $modx->getOption('tplWrapper', $scriptProperties, 'exerplan.assessment.wrapper');

$defaultExerPlanCorePath = $modx->getOption('core_path') . 'components/exerplan/';
$exerplanCorePath = $modx->getOption('exerplan.core_path', null, $defaultExerPlanCorePath);
$exerplan = $modx->getService('exerplan', 'ExerPlan', $exerplanCorePath . 'model/', $scriptProperties);

if (!($exerplan instanceof ExerPlan)) {
    return;
}
$exerplan->setConfigs($scriptProperties);

$assessments = $exerplan->assessmentsArray();

$output = '';
if (!empty($toArray)) {
    $output = '<pre>' . print_r($assessments, TRUE) . '</pre>';
} else {
    $assessmentsArray = array();
    foreach ($assessments as $assessment) {
        $assessmentItemOutput = $exerplan->parseTpl($tplItem, $assessment);
        $assessmentItemOutput = $exerplan->processElementTags($assessmentItemOutput);
        $assessmentsArray[] = $assessmentItemOutput;
    }
    $assessmentsString = @implode($itemSeparator, $assessmentsArray);
    $assessmentWrapper = array(
        $scriptProperties['phsPrefix'] . $scriptProperties['assessmentPrefix'] . 'items' => $assessmentsString
    );
    $output = $exerplan->parseTpl($tplWrapper, $assessmentWrapper);
    $output = $exerplan->processElementTags($output);
}
if (!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $output);
    return;
}

return $output;