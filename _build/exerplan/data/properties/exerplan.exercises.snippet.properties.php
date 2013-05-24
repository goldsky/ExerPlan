<?php

/**
 * ExerPlan
 *
 * Copyright 2013 by goldsky <goldsky@virtudraft.com>
 *
 * This file is part of ExerPlan
 *
 * ExerPlan build script
 *
 * @package exerplan
 * @subpackage build
 */

if (!function_exists("fixJson")) {

    function fixJson(array $array) {
        $fixed = array();
        foreach ($array as $k => $v) {
            $fixed[] = array(
                'name' => $v['name'],
                'desc' => $v['desc'],
                'type' => $v['xtype'],
                'options' => empty($v['options']) ? '' : $v['options'],
                'value' => $v['value'],
                'lexicon' => $v['lexicon'],
            );
        }
        return $fixed;
    }

}

ob_start();
include dirname(__FILE__) . '/default.exerplan.exercises.snippet.properties.js';
$json = ob_get_contents();
ob_end_clean();

$properties = $modx->fromJSON($json);
$properties = fixJson($properties);

return $properties;