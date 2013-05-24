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

class AssessmentsCreateProcessor extends modObjectCreateProcessor {

    public $classKey = 'Assessments';
    public $languageTopics = array('exerplan:cmp');
    public $objectType = 'exerplan.AssessmentsCreate';

    /**
     * {@inheritDoc}
     * @return boolean
     */
    public function initialize() {
        $userId = $this->modx->user->get('id');
        $this->setProperty('created_by', $userId);
        $createdFor = $this->getProperty('created_for');
        $this->setProperty('created_for', $createdFor);
        $this->setProperty('created_on', time());

        return parent::initialize();
    }

    public function beforeSave() {
        $assessment = $this->getProperty('assessment');

        if (empty($assessment)) {
            $this->addFieldError('assessment', $this->modx->lexicon('exerplan.assessment_err_ns'));
        }

        $createdFor = $this->getProperty('created_for');
        if (empty($assessment)) {
            $this->addFieldError('created_for', $this->modx->lexicon('exerplan.created_for_err_ns'));
        }

        return parent::beforeSave();
    }

}

return 'AssessmentsCreateProcessor';