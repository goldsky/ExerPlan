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
 * @subpackage exerplan
 */

class ExerPlan {

    const version = '1.0.0.pl';

    public $modx;
    public $config;

    /**
     * constructor
     * @param   modX    $modx
     * @param   array   $config     parameters
     */
    public function __construct(modX $modx, $config = array()) {
        $this->modx = & $modx;
        $config = is_array($config) ? $config : array();
        $basePath = $this->modx->getOption('exerplan.core_path', $config, $this->modx->getOption('core_path') . 'components/exerplan/');
        $assetsUrl = $this->modx->getOption('exerplan.assets_url', $config, $this->modx->getOption('assets_url') . 'components/exerplan/');
        $this->config = array_merge(array(
            'version' => self::version,
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath . 'model/',
            'processorsPath' => $basePath . 'processors/',
            'chunksPath' => $basePath . 'elements/chunks/',
            'templatesPath' => $basePath . 'templates/',
            'jsUrl' => $assetsUrl . 'js/',
            'cssUrl' => $assetsUrl . 'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl . 'conn/mgr.php',
                ), $config);

        $this->modx->lexicon->load('exerplan:default');
        $this->modx->addPackage('exerplan', $this->config['modelPath'], 'modx_exerplan_');
    }

    /**
     * Set class configuration exclusively for multiple snippet calls
     * @param   array   $config     snippet's parameters
     */
    public function setConfigs(array $config = array()) {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * Define individual config for the class
     * @param   string  $key    array's key
     * @param   string  $val    array's value
     */
    public function setConfig($key, $val) {
        $this->config[$key] = $val;
    }

    /**
     * Parsing template
     * @param   string  $tpl    @BINDINGs options
     * @param   array   $phs    placeholders
     * @return  string  parsed output
     * @link    http://forums.modx.com/thread/74071/help-with-getchunk-and-modx-speed-please?page=2#dis-post-413789
     */
    public function parseTpl($tpl, array $phs = array()) {
        $output = '';
        if (preg_match('/^(@CODE|@INLINE)/i', $tpl)) {
            $tplString = preg_replace('/^(@CODE|@INLINE)/i', '', $tpl);
            // tricks @CODE: / @INLINE:
            $tplString = ltrim($tplString, ':');
            $tplString = trim($tplString);
            $output = $this->parseTplCode($tplString, $phs);
        } elseif (preg_match('/^@FILE/i', $tpl)) {
            $tplFile = preg_replace('/^@FILE/i', '', $tpl);
            // tricks @FILE:
            $tplFile = ltrim($tplFile, ':');
            $tplFile = trim($tplFile);
            $tplFile = $this->replacePropPhs($tplFile);
            try {
                $output = $this->parseTplFile($tplFile, $phs);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        // ignore @CHUNK / @CHUNK: / empty @BINDING
        else {
            $tplChunk = preg_replace('/^@CHUNK/i', '', $tpl);
            // tricks @CHUNK:
            $tplChunk = ltrim($tpl, ':');
            $tplChunk = trim($tpl);

            $chunk = $this->modx->getObject('modChunk', array('name' => $tplChunk), true);
            if (empty($chunk)) {
                // try to use @splittingred's fallback
                $f = $this->config['chunksPath'] . strtolower($tplChunk) . '.chunk.tpl';
                try {
                    $output = $this->parseTplFile($f, $phs);
                } catch (Exception $e) {
                    $output = $e->getMessage();
                    return 'Chunk: ' . $tplChunk . ' is not found, neither the file ' . $output;
                }
            } else {
//                $output = $this->modx->getChunk($tpl, $phs);
                /**
                 * @link    http://forums.modx.com/thread/74071/help-with-getchunk-and-modx-speed-please?page=4#dis-post-464137
                 */
                $chunk = $this->modx->getParser()->getElement('modChunk', $tpl);
                $chunk->setCacheable(false);
                $chunk->_processed = false;
                $output = $chunk->process($phs);
            }
        }

        return $output;
    }

    /**
     * Parsing inline template code
     * @param   string  $code   HTML with tags
     * @param   array   $phs    placeholders
     * @return  string  parsed output
     */
    public function parseTplCode($code, array $phs = array()) {
        $chunk = $this->modx->newObject('modChunk');
        $chunk->setContent($code);
        $chunk->setCacheable(false);
        $phs = $this->replacePropPhs($phs);
        $chunk->_processed = false;
        return $chunk->process($phs);
    }

    /**
     * Parsing file based template
     * @param   string  $file   file path
     * @param   array   $phs    placeholders
     * @return  string  parsed output
     * @throws  Exception if file is not found
     */
    public function parseTplFile($file, array $phs = array()) {
        if (!file_exists($file)) {
            throw new Exception('File: ' . $file . ' is not found.');
        }
        $o = file_get_contents($file);
        $chunk = $this->modx->newObject('modChunk');

        // just to create a name for the modChunk object.
        $name = strtolower(basename($file));
        $name = rtrim($name, '.tpl');
        $name = rtrim($name, '.chunk');
        $chunk->set('name', $name);

        $chunk->setCacheable(false);
        $chunk->setContent($o);
        $chunk->_processed = false;
        $output = $chunk->process($phs);

        return $output;
    }

    /**
     * If the chunk is called by AJAX processor, it needs to be parsed for the
     * other elements to work, like snippet and output filters.
     *
     * Example:
     * <pre><code>
     * <?php
     * $content = $myObject->parseTpl('tplName', $placeholders);
     * $content = $myObject->processElementTags($content);
     * </code></pre>
     *
     * @param   string  $content    the chunk output
     * @param   array   $options    option for iteration
     * @return  string  parsed content
     */
    public function processElementTags($content, array $options = array()) {
        $maxIterations = intval($this->modx->getOption('parser_max_iterations', $options, 10));
        $this->modx->parser->processElementTags('', $content, true, false, '[[', ']]', array(), $maxIterations);
        $this->modx->parser->processElementTags('', $content, true, true, '[[', ']]', array(), $maxIterations);
        return $content;
    }

    /**
     * Replace the property's placeholders
     * @param   string|array    $subject    Property
     * @return  array           The replaced results
     */
    public function replacePropPhs($subject) {
        $pattern = array(
            '/\{core_path\}/',
            '/\{base_path\}/',
            '/\{assets_url\}/',
            '/\{filemanager_path\}/',
            '/\[\[\+\+core_path\]\]/',
            '/\[\[\+\+base_path\]\]/'
        );
        $replacement = array(
            $this->modx->getOption('core_path'),
            $this->modx->getOption('base_path'),
            $this->modx->getOption('assets_url'),
            $this->modx->getOption('filemanager_path'),
            $this->modx->getOption('core_path'),
            $this->modx->getOption('base_path')
        );
        if (is_array($subject)) {
            $parsedString = array();
            foreach ($subject as $k => $s) {
                if (is_array($s)) {
                    $s = $this->replacePropPhs($s);
                }
                $parsedString[$k] = preg_replace($pattern, $replacement, $s);
            }
            return $parsedString;
        } else {
            return preg_replace($pattern, $replacement, $subject);
        }
    }

    public function usergroupWorkouts() {
        $c = $this->modx->newQuery('Workouts');
        $c->innerJoin('UsergroupsWorkouts', 'UsergroupsWorkouts');
        $c->leftJoin('Levels', 'Levels', 'Levels.id = Workouts.level_id');
        $c->leftJoin('modUserGroup', 'UserGroup', 'UserGroup.id = UsergroupsWorkouts.usergroup_id');
        $c->select(array(
            'Workouts.*',
            'level_name' => 'Levels.level',
            'usergroup' => 'UserGroup.name',
        ));
        if (!empty($this->config['userId'])) {
            $userObj = $this->modx->getObject('modUser', $this->config['userId']);
            $usergroups = $userObj->getUserGroups();
            $c->where(array(
                'UsergroupsWorkouts.usergroup_id:IN' => $usergroups
            ));
        }
        $c->sortby($this->config['sortby'], $this->config['sortdir']);
        $usergroupWorkoutsCollection = $this->modx->getCollection('Workouts', $c);
        $usergroupWorkoutsArray = array();
        foreach ($usergroupWorkoutsCollection as $workout) {
            $usergroupWorkoutsArray[] = $this->workoutToArray($workout);
        }

        return $usergroupWorkoutsArray;
    }

    public function userWorkouts() {
        $c = $this->modx->newQuery('Workouts');
        $c->innerJoin('UsersWorkouts', 'UsersWorkouts');
        $c->leftJoin('Levels', 'Levels', 'Levels.id = Workouts.level_id');
        $c->select(array(
            'Workouts.*',
            'level_name' => 'Levels.level',
        ));
        if (!empty($this->config['userId'])) {
            $c->where(array(
                'UsersWorkouts.user_id' => $this->config['userId']
            ));
        }
        $c->sortby($this->config['sortby'], $this->config['sortdir']);
        $userWorkoutsCollection = $this->modx->getCollection('Workouts', $c);
        $userWorkoutsArray = array();
        foreach ($userWorkoutsCollection as $workout) {
            $userWorkoutsArray[] = $this->workoutToArray($workout);
        }

        return $userWorkoutsArray;
    }

    public function workoutToArray(Workouts $workout) {
        $workoutsArray = $workout->toArray($this->config['phsPrefix']);

        $galleriesArray = array();
        if ($this->config['getGalleries']) {
            $galleries = $this->workoutGalleries($workout);
            if ($galleries) {
                foreach ($galleries as $gallery) {
                    $galleryArray = $gallery->toArray($this->config['phsPrefix'] . $this->config['galleryPrefix']);

                    $controller = $this->replacePropPhs($galleryArray[$this->config['phsPrefix'] . $this->config['galleryPrefix'] . 'controller']);
                    $controller = $this->processElementTags($controller);
                    $sourceController = $this->replacePropPhs($galleryArray[$this->config['phsPrefix'] . $this->config['galleryPrefix'] . 'source.controller']);
                    $sourceController = $this->processElementTags($sourceController);
                    if (empty($controller) && !empty($sourceController)) {
                        $controller = $sourceController;
                    }
                    if (!empty($controller)) {
                        $controllerOutput = $this->galleryController($controller, $galleryArray);
                        $galleryArray[$this->config['phsPrefix'] . $this->config['galleryPrefix'] . 'controller.output'] = $controllerOutput;
                    }
                    $galleriesArray[] = $galleryArray;
                }
            }
        }

        $workoutsArray[$this->config['phsPrefix'] . 'galleries'] = $galleriesArray;

        return $workoutsArray;
    }

    protected function galleryController($controller, $placeholders) {
        $isSnippet = $this->modx->getObject('modSnippet', array('name' => $controller));
        if ($isSnippet) {
            $controllerOutput = $this->modx->runSnippet($controller, $placeholders);
        } elseif (file_exists($controller)) {
            // shorthands
            $modx = $this->modx;
            $scriptProperties = $this->config;
            $controllerOutput = include $controller;
        } else {
            $controllerOutput = '';
        }
        return $controllerOutput;
    }

    public function galleriesQuery() {
        $c = $this->modx->newQuery('Galleries');
        $c->innerJoin('GallerySources');
        $c->innerJoin('GalleryMediatypes');
        $c->select(array(
            'Galleries.id',
            'Galleries.url',
            'Galleries.name',
            'Galleries.description',
            'Galleries.data',
            'GallerySources.source',
            "{$this->modx->escape('source.controller')}" => 'GallerySources.controller',
            'GalleryMediatypes.mediatype',
        ));
        if (!empty($this->config['gallerySource'])) {
            $c->where(array(
                'GallerySources.source' => $this->config['gallerySource']
            ));
        }
        if (!empty($this->config['galleryMediatype'])) {
            $c->where(array(
                'GalleryMediatypes.mediatype' => $this->config['galleryMediatype']
            ));
        }

        return $c;
    }

    public function workoutGalleries(Workouts $workout) {
        $c = $this->galleriesQuery();
        return $workout->getMany('Galleries', $c);
    }

    public function galleriesArray() {
        $c = $this->galleriesQuery();
        if (!empty($this->config['workoutId'])) {
            $c->where(array(
                'Galleries.workout_id' => $this->config['workoutId']
            ));
        }
        if (!empty($this->config['userId'])) {
            $c->where(array(
                'Galleries.user_id' => $this->config['userId']
            ));
        }
        $c->sortby($this->config['sortby'], $this->config['sortdir']);
        $collection = $this->modx->getCollection('Galleries', $c);
        $galleries = array();
        if ($collection) {
            foreach ($collection as $item) {
                $galleries[] = $item->toArray($this->config['phsPrefix'] . $this->config['galleryPrefix']);
            }
        }

        return $galleries;
    }

    public function assessmentsArray() {
        $c = $this->modx->newQuery('Assessments');
        $c->leftJoin('modUserProfile', 'Assessor', 'Assessments.created_by = Assessor.id');
        $c->leftJoin('modUserProfile', 'Assessee', 'Assessments.created_for = Assessee.id');
        $c->select(array(
            'Assessments.*',
            $this->modx->getSelectColumns('modUserProfile', 'Assessor', 'assessor.', array('id', 'internalKey', 'internalKey', 'blocked', 'blockeduntil', 'blockedafter',
                'logincount', 'lastlogin', 'thislogin', 'failedlogincount', 'sessionid'
                    ), true),
            $this->modx->getSelectColumns('modUserProfile', 'Assessee', 'assessee.', array('id', 'internalKey', 'internalKey', 'blocked', 'blockeduntil', 'blockedafter',
                'logincount', 'lastlogin', 'thislogin', 'failedlogincount', 'sessionid'
                    ), true),
        ));
        if (!empty($this->config['assessorId'])) {
            $c->where(array(
                'Assessments.created_by' => $this->config['assessorId']
            ));
        }
        if (!empty($this->config['assesseeId'])) {
            $c->where(array(
                'Assessments.created_for' => $this->config['assesseeId']
            ));
        }
        if (empty($this->config['showHidden'])) {
            $c->where(array(
                'Assessments.is_hidden' => 0
            ));
        }

        $c->sortby($this->config['sortby'], $this->config['sortdir']);

        $collection = $this->modx->getCollection('Assessments', $c);
        $assessments = array();
        if ($collection) {
            $i = 0;
            foreach ($collection as $item) {
                $itemArray = $item->toArray($this->config['phsPrefix'] . $this->config['assessmentPrefix']);
                $itemArray[$this->config['phsPrefix'] . $this->config['assessmentPrefix'] . 'row_index'] = $i;
                $assessments[] = $itemArray;
                $i++;
            }
        }

        return $assessments;
    }

}