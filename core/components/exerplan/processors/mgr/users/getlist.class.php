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

class UsersGetListProccessor extends modObjectGetListProcessor {

    public $classKey = 'modUser';
    public $languageTopics = array('exerplan:cmp');
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'exerplan.UsersGetList';

    /**
     * {@inheritDoc}
     * @return boolean
     */
    public function initialize() {
        $this->setDefaultProperties(array(
            'start' => 0,
            'limit' => 0, // 20
            'sort' => $this->defaultSortField,
            'dir' => $this->defaultSortDirection,
            'combo' => false,
            'query' => '',
        ));
        return true;
    }

    /**
     * Can be used to adjust the query prior to the COUNT statement
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->innerJoin('modUserProfile', 'Profile');
        $c->innerJoin('modUserGroupMember', 'UserGroupMembers');
        $groupId = $this->getProperty('ugid');
        $c->where('UserGroupMembers.user_group=' . $groupId);
        return $c;
    }

    /**
     * Can be used to prepare the query after the COUNT statement
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryAfterCount(xPDOQuery $c) {
        $c->select($this->modx->getSelectColumns('modUser', 'modUser', '', array('id', 'username')));
        $c->select($this->modx->getSelectColumns('modUserProfile', 'Profile', '', array('fullname', 'email')));
        return $c;
    }

    /**
     * Prepare the row for iteration
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $objectArray = $object->toArray();
        unset(
                $objectArray['password']
                , $objectArray['cachepwd']
                , $objectArray['salt']
                , $objectArray['class_key']
                , $objectArray['active']
                , $objectArray['remote_key']
                , $objectArray['remote_data']
                , $objectArray['hash_class']
                , $objectArray['primary_group']
                , $objectArray['session_stale']
                , $objectArray['sudo']
                , $objectArray['blocked']
        );
        $objectArray['uid'] = $objectArray['id'];
        $objectArray['text'] = !empty($objectArray['fullname']) ? $objectArray['fullname'] : $objectArray['username'];
        $objectArray['leaf'] = true;
        unset($objectArray['id']); // avoid Ext component's ID

        return $objectArray;
    }

}

return 'UsersGetListProccessor';