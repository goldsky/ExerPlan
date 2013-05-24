ExerPlan.grid.WorkoutsUsergroup = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'exerplan-grid-workouts-usergroup',
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/workouts/getList',
            usergroup_id: config.node.attributes.ugid
        },
        fields: ['id', 'name', 'description', 'goal', 'level_id', 'level',
            'set', 'repetition', 'rest_time', 'rest_time_unit',
            'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun',
            'timely_rep', 'timely_unit', 'sort'
        ],
        paging: true,
        remoteSort: true,
        anchor: '97%',
        autoExpandColumn: 'description',
        columns: [
            {
                header: _('id'),
                dataIndex: 'id',
                sortable: true,
                hidden: true,
                width: 40
            }, {
                header: _('exerplan.name'),
                dataIndex: 'name',
                sortable: true,
                width: 60
            }, {
                header: _('exerplan.description'),
                dataIndex: 'description'
            }, {
                header: _('exerplan.sets'),
                dataIndex: 'set',
                width: 40
            }, {
                header: _('exerplan.reps'),
                dataIndex: 'repetition',
                width: 40
            }
        ],
        tbar: [{
                text: _('exerplan.workout_create'),
//                handler: {
//                    xtype: 'exerplan-window-usergroup-select-workout',
//                    node: config.node,
//                    title: _('exerplan.workout_create')
//                }
                handler: function() {
                    var workoutWindow = new ExerPlan.window.UsergroupSelectWorkout({
                        node: config.node,
                        title: _('exerplan.workout_create'),
                        listeners: {
                            success: {
                                fn: this.refresh,
                                scope: this
                            }
                        }
                    });
                    return workoutWindow.show();
                }
            }
        ]
    });

    ExerPlan.grid.WorkoutsUsergroup.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.grid.WorkoutsUsergroup, MODx.grid.Grid, {
    getMenu: function() {
        return [{
                text: _('exerplan.remove'),
                handler: this.removeWorkout
            }];
    },
    removeWorkout: function() {
        MODx.msg.confirm({
            title: _('exerplan.workout_remove'),
            text: _('exerplan.workout_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/usergroups/removeworkout',
                workout_id: this.menu.record.id,
                usergroup_id: this.node.attributes.ugid
            },
            listeners: {
                'success': {
                    fn: this.refresh,
                    scope: this
                }
            }
        });
    }
});
Ext.reg('exerplan-grid-workouts-usergroup', ExerPlan.grid.WorkoutsUsergroup);

ExerPlan.window.UsergroupSelectWorkout = function(config) {
    config = config || {};

    Ext.apply(config, {
        id: 'exerplan-window-usergroup-select-workout',
        closeAction: 'close',
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/usergroups/addworkout',
            usergroup_id: config.node.attributes.ugid
        },
        defaults: {
            anchor: '100%'
        },
        fields: [
            {
                xtype: 'exerplan-combo-workouts',
                anchor: '100%'
            }
        ]
    });
    ExerPlan.window.UsergroupSelectWorkout.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.window.UsergroupSelectWorkout, MODx.Window);
Ext.reg('exerplan-window-usergroup-select-workout', ExerPlan.window.UsergroupSelectWorkout);