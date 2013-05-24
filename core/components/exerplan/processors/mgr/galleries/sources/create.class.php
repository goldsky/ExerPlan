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

class GallerySourcesCreateProcessor extends modObjectCreateProcessor {

    public $classKey = 'GallerySources';
    public $languageTopics = array('exerplan:cmp');
    public $objectType = 'exerplan.GallerySourcesCreate';

    public function beforeSave() {
        $source = $this->getProperty('source');

        if (empty($source)) {
            $this->addFieldError('source', $this->modx->lexicon('exerplan.source_err_ns_source'));
        } else if ($this->doesAlreadyExist(array('source' => $source))) {
            $this->addFieldError('source', $this->modx->lexicon('exerplan.source_err_ae'));
        }
        return parent::beforeSave();
    }

}

return 'GallerySourcesCreateProcessor';