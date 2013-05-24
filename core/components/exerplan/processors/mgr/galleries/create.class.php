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
 * @subpackage processor
 */

class GalleriesCreateProcessor extends modObjectCreateProcessor {

    public $classKey = 'Galleries';
    public $languageTopics = array('exerplan:cmp');
    public $objectType = 'exerplan.GalleriesCreate';

    public function beforeSave() {
        $url = $this->getProperty('url');
        if (empty($url)) {
            $this->addFieldError('url', $this->modx->lexicon('exerplan.gallery_err_ns_url'));
        }
        $workoutId = $this->getProperty('workout_id');
        $userId = $this->getProperty('user_id');
        $sourceId = $this->getProperty('source_id');
        if ($this->doesAlreadyExist(array(
                    'workout_id' => $workoutId,
                    'user_id' => $userId,
                    'source_id' => $sourceId,
                    'url' => $url,
                ))) {
            $this->addFieldError('url', $this->modx->lexicon('exerplan.gallery_err_ae'));
        }
        return parent::beforeSave();
    }

}

return 'GalleriesCreateProcessor';