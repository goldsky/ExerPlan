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

/**
 * @param   string  $filename   filename
 * @return  string  file content
 */
function getSnippetContent($filename) {
    $o = file_get_contents($filename);
    $o = str_replace('<?php', '', $o);
    $o = str_replace('?>', '', $o);
    $o = trim($o);
    return $o;
}

$snippets = array();

$snippets[0] = $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 0,
    'property_preprocess' => 1,
    'name' => 'exerplan.Exercises',
    'description' => 'Get work outs for specified member.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/exerplan.exercises.snippet.php'),
        ), '', true, true);
$properties = include $sources['properties'] . 'exerplan.exercises.snippet.properties.php';
$snippets[0]->setProperties($properties);
unset($properties);

$snippets[1] = $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1,
    'property_preprocess' => 1,
    'name' => 'exerplan.Galleries',
    'description' => 'Get individual Galleries for specified member, eg instructional videos or pictures.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/exerplan.galleries.snippet.php'),
        ), '', true, true);
$properties = include $sources['properties'] . 'exerplan.galleries.snippet.properties.php';
$snippets[1]->setProperties($properties);
unset($properties);

$snippets[2] = $modx->newObject('modSnippet');
$snippets[2]->fromArray(array(
    'id' => 2,
    'property_preprocess' => 1,
    'name' => 'exerplan.Assessments',
    'description' => 'Get assessments from mentor(s) for specified member.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/exerplan.assessments.snippet.php'),
        ), '', true, true);
$properties = include $sources['properties'] . 'exerplan.assessments.snippet.properties.php';
$snippets[2]->setProperties($properties);
unset($properties);

return $snippets;