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

class UsersUsergroupsGetListProcessor extends modObjectGetListProcessor {

    public $classKey = 'modUserGroupMember';
    public $languageTopics = array('exerplan:cmp');
    public $objectType = 'exerplan.UsersUsergroupsGetList';

    /** @var string $defaultSortField The default field to sort by */
    public $defaultSortField = 'id';

    /**
     * Can be used to adjust the query prior to the COUNT statement
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->innerJoin('modUserGroup', 'UserGroup');
        $c->select(array(
            'modUserGroupMember.*',
            'UserGroup.*'
        ));
        $userId = $this->getProperty('user_id');
        $c->where('member=' . $userId);
        return $c;
    }

    /**
     * Return arrays of objects (with count) converted to JSON.
     *
     * The JSON result includes two main elements, total and results. This format is used for list
     * results.
     *
     * @access public
     * @param array $array An array of data objects.
     * @param mixed $count The total number of objects. Used for pagination.
     * @return string The JSON output.
     */
    public function outputArray(array $array, $count = false) {
        if ($count === false) {
            $count = count($array);
            $output = $this->failure('', $array);
        } else {
            $this->modx->error->total = $count;
            $output = $this->success('', $array);
        }
        return $output;
    }

}

return 'UsersUsergroupsGetListProcessor';