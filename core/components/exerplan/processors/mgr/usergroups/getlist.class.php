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

class UsergroupsGetListProccessor extends modObjectGetListProcessor {

    public $classKey = 'modUserGroup';
    public $languageTopics = array('exerplan:cmp');
    public $objectType = 'exerplan.UsergroupsGetList';

    /**
     * {@inheritDoc}
     * @return boolean
     */
    public function initialize() {
        $this->setDefaultProperties(array(
            'start' => 0,
//            'limit' => 20,
            'limit' => 0,
            'sort' => $this->defaultSortField,
            'dir' => $this->defaultSortDirection,
            'combo' => false,
            'query' => '',
        ));
        return true;
    }

    /**
     * Prepare the row for iteration
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $objectArray = $object->toArray();
        $objectArray['ugid'] = $objectArray['id'];
        $objectArray['text'] = $objectArray['name'];
        $objectArray['leaf'] = $this->_leaf($objectArray);
        unset($objectArray['id']); // avoid Ext component's ID

        return $objectArray;
    }

    private function _leaf($objectArray) {
        $leaf = true;

        $c = $this->modx->newQuery('modUser');
        $c->innerJoin('modUserGroupMember', 'UserGroupMembers');
        $c->leftJoin('modUserGroup', 'UserGroup', 'UserGroup.id = UserGroupMembers.user_group');

        $c->where(array(
            'UserGroupMembers.user_group' => $objectArray['id']
        ));
		$c->limit(1);

        $collection = $this->modx->getCollection('modUser', $c);
        if ($collection) {
            $leaf = false;
        }

        return $leaf;
    }

}

return 'UsergroupsGetListProccessor';