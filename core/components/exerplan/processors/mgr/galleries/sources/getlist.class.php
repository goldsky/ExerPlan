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

class GallerySourcesGetListProccessor extends modObjectGetListProcessor {

    public $classKey = 'GallerySources';
    public $languageTopics = array('exerplan:cmp');
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'exerplan.GallerySourcesGetList';

    /**
     * Can be used to adjust the query prior to the COUNT statement
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->leftJoin('GalleryMediatypes', 'GalleryMediatypes', 'GalleryMediatypes.id = GallerySources.mediatype_id');
        $c->select(array(
            'GallerySources.*',
            'GalleryMediatypes.mediatype',
        ));
        return $c;
    }

}

return 'GallerySourcesGetListProccessor';