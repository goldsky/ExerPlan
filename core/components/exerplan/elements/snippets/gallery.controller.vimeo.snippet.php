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
 * @subpackage controller_snippet
 */

$vimeoUserName = $modx->getOption('exerplan.vimeo.username', $scriptProperties, 'brad');

// Endpoints
$apiEndPoint = 'http://vimeo.com/api/v2/' . $vimeoUserName;
$oEmbedEndPoint = 'http://vimeo.com/api/oembed.xml';

// Curl helper function
if (!function_exists('curl_get')) {

    function curl_get($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($curl);
        curl_close($curl);
        return $return;
    }

}

// Get the url for the latest video
$videos = simplexml_load_string(curl_get($apiEndPoint . '/videos.xml'));
$videoUrl = !empty($placeholders['exerplan.gallery.url']) ? $placeholders['exerplan.gallery.url'] : $videos->video[0]->url;
$videoUrl = $videos->video[0]->url;

// Create the URL
$oEmbedUrl = $oEmbedEndPoint . '?url=' . rawurlencode($videoUrl);

// Load in the oEmbed XML
$oEmbed = simplexml_load_string(curl_get($oEmbedUrl));
$embedCode = html_entity_decode($oEmbed->html);

return $embedCode;