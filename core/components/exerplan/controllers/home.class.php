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
 * @subpackage controller
 */

class ExerPlanHomeManagerController extends ExerPlanManagerController {

    public function process(array $scriptProperties = array()) {

    }

    public function getPageTitle() {
        return $this->modx->lexicon('exerplan');
    }

    public function loadCustomCssJs() {
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'ux/DataView-more.js');
		$this->addJavascript($this->exerplan->config['jsUrl'] . 'ux/CheckColumn.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/combo.gallery.mediatypes.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/combo.gallery.sources.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/combo.workouts.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/grid.workouts.usergroup.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/grid.workouts.user.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/grid.workouts.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/panel.workouts.grid.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/grid.levels.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/window.gallery.url.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/grid.setting.gallery.mediatypes.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/grid.setting.gallery.sources.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/grid.user.assessments.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/grid.user.galleries.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/grid.workout.galleries.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/panel.galleries.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/panel.galleries.content.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/tree.workouts.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/panel.workouts.galleries.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/panel.usergroups.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/panel.users.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/panel.users.content.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/tree.users.js');
        $this->addJavascript($this->exerplan->config['jsUrl'] . 'mgr/widgets/panel.home.js');
        $this->addLastJavascript($this->exerplan->config['jsUrl'] . 'mgr/sections/index.js');
    }

    public function getTemplateFile() {
        return $this->exerplan->config['templatesPath'] . 'home.tpl';
    }

}