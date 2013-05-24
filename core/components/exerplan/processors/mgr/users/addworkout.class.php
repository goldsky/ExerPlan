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

class UsersAddWorkoutsProcessor extends modObjectUpdateProcessor {

    public $classKey = 'Workouts';
    public $languageTopics = array('exerplan:cmp');
    public $objectType = 'exerplan.UsersAddWorkouts';

    public function beforeSave() {
        $props = $this->getProperties();
        $check = $this->modx->getObject('UsersWorkouts', array(
            'user_id' => $props['user_id'],
            'workout_id' => $props['id']
        ));
        if ($check) {
            $this->addFieldError('name', $this->modx->lexicon('exerplan.UsersWorkouts_err_ae'));
        }
        return parent::beforeSave();
    }

    /**
     * {@inheritDoc}
     * @return mixed
     */
    public function process() {
        /* Run the beforeSet method before setting the fields, and allow stoppage */
        $canSave = $this->beforeSet();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }

        $props = $this->getProperties();
        $newObject = $this->modx->newObject('UsersWorkouts');
        $newObject->set('user_id', $props['user_id']);
        $newObject->set('workout_id', $props['id']);

        $newUsersWorkouts = array($newObject);
        $this->object->addMany($newUsersWorkouts);

        /* Run the beforeSave method and allow stoppage */
        $canSave = $this->beforeSave();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }

        /* run object validation */
        if (!$this->object->validate()) {
            /** @var modValidator $validator */
            $validator = $this->object->getValidator();
            if ($validator->hasMessages()) {
                foreach ($validator->getMessages() as $message) {
                    $this->addFieldError($message['field'], $this->modx->lexicon($message['message']));
                }
            }
        }

        /* run the before save event and allow stoppage */
        $preventSave = $this->fireBeforeSaveEvent();
        if (!empty($preventSave)) {
            return $this->failure($preventSave);
        }

        if ($this->saveObject() == false) {
            return $this->failure($this->modx->lexicon($this->objectType . '_err_save'));
        }
        $this->afterSave();
        $this->fireAfterSaveEvent();
        $this->logManagerAction();
        return $this->cleanup();
    }

}

return 'UsersAddWorkoutsProcessor';