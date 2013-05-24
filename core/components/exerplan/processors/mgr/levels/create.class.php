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

class LevelsCreateProcessor extends modObjectCreateProcessor {

    public $classKey = 'Levels';
    public $languageTopics = array('exerplan:cmp');
    public $objectType = 'exerplan.LevelsCreate';

    public function beforeSave() {
        $level = $this->getProperty('level');

        if (empty($level)) {
            $this->addFieldError('level', $this->modx->lexicon('exerplan.level_err_ns_level'));
        } else if ($this->doesAlreadyExist(array('level' => $level))) {
            $this->addFieldError('level', $this->modx->lexicon('exerplan.level_err_ae'));
        }
        return parent::beforeSave();
    }

}

return 'LevelsCreateProcessor';