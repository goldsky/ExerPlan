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

class UsersWorkoutsRemoveProcessor extends modObjectRemoveProcessor {

    public $classKey = 'UsersWorkouts';
    public $languageTopics = array('exerplan:cmp');
    public $objectType = 'exerplan.UsersWorkoutsRemove';

    public function initialize() {
        $workoutKey = $this->getProperty('workout_id', false);
        if (empty($workoutKey))
            return $this->modx->lexicon($this->objectType . '_err_ns');
        $usergroupKey = $this->getProperty('user_id', false);
        if (empty($usergroupKey))
            return $this->modx->lexicon($this->objectType . '_err_ns');

        $this->object = $this->modx->getObject($this->classKey, array(
            'user_id' => $usergroupKey,
            'workout_id' => $workoutKey,
        ));
        if (empty($this->object))
            return $this->modx->lexicon($this->objectType . '_err_nfs', array($this->primaryKeyField => $primaryKey));

        if ($this->checkRemovePermission && $this->object instanceof modAccessibleObject && !$this->object->checkPolicy('remove')) {
            return $this->modx->lexicon('access_denied');
        }
        return true;
    }

}

return 'UsersWorkoutsRemoveProcessor';