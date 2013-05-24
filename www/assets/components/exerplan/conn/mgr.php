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
 * @subpackage controller
 */

require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('exerplan.core_path', null, $modx->getOption('core_path') . 'components/exerplan/');
require_once $corePath . 'model/exerplan.class.php';
$modx->exerplan = new ExerPlan($modx);

$modx->lexicon->load('exerplan:cmp');

/* handle request */
$path = $modx->getOption('processorsPath', $modx->exerplan->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path,
	'location' => '',
));