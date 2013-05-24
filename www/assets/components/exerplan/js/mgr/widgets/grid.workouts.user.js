ExerPlan.grid.WorkoutsUser = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'exerplan-grid-workouts-user',
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/workouts/getList',
            user_id: config.node.attributes.uid
        },
        fields: ['id', 'name', 'description', 'goal', 'level_id', 'level',
            'set', 'repetition', 'rest_time', 'rest_time_unit',
            'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun',
            'timely_rep', 'timely_unit', 'sort'
        ],
        paging: true,
        remoteSort: true,
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
//                    xtype: 'exerplan-window-user-select-workout',
//                    node: config.node,
//                    title: _('exerplan.workout_create')
//                }
                handler: function() {
                    var workoutWindow = new ExerPlan.window.UserSelectWorkout({
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

    ExerPlan.grid.WorkoutsUser.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.grid.WorkoutsUser, MODx.grid.Grid, {
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
                action: 'mgr/users/removeworkout',
                workout_id: this.menu.record.id,
                user_id: this.node.attributes.uid
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
Ext.reg('exerplan-grid-workouts-user', ExerPlan.grid.WorkoutsUser);

ExerPlan.window.UserSelectWorkout = function(config) {
    config = config || {};

    Ext.apply(config, {
        id: 'exerplan-window-user-select-workout',
        closeAction: 'close',
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/users/addworkout',
            user_id: config.node.attributes.uid
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
    ExerPlan.window.UserSelectWorkout.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.window.UserSelectWorkout, MODx.Window);
Ext.reg('exerplan-window-user-select-workout', ExerPlan.window.UserSelectWorkout);