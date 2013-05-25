ExerPlan.grid.Workouts = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'exerplan-grid-workouts',
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/workouts/getList'
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
        save_action: 'mgr/workouts/updateFromGrid',
        autosave: true,
        bodyStyle: 'overflow: auto;',
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
                width: 60,
                editor: {
                    xtype: 'textfield'
                }
            }, {
                header: _('exerplan.description'),
                dataIndex: 'description',
                editor: {
                    xtype: 'textarea'
                }
            }, {
                header: _('exerplan.sets'),
                dataIndex: 'set',
                width: 40,
                editor: {
                    xtype: 'textfield'
                }
            }, {
                header: _('exerplan.reps'),
                dataIndex: 'repetition',
                width: 40,
                editor: {
                    xtype: 'textfield'
                }
            }
        ],
        tbar: [
            {
                text: _('exerplan.workout_create'),
                id: 'exerplan-window-workout-button',
                handler: {
                    xtype: 'exerplan-window-workout',
                    title: _('exerplan.workout_create'),
                    baseParams: {
                        action: 'mgr/workouts/create'
                    },
                    blankValues: true
                }
            }, {
                text: _('exerplan.manage_galleries'),
                id: 'exerplan-panel-workouts-galleries-button',
//                handler: {
//                    xtype: 'exerplan-panel-workouts-galleries'
//                }
                handler: function() {
                    var workoutsGalleries = new ExerPlan.panel.WorkoutsGalleries(config);
                    return workoutsGalleries.show();
                }
            }
        ],
        listeners: {
            destroy: function(obj) {
                var windowButton = Ext.getCmp('exerplan-window-workout-button');
                if (windowButton)
                    windowButton.destroy();
                var galleriesButton = Ext.getCmp('exerplan-panel-workouts-galleries-button');
                if (galleriesButton)
                    galleriesButton.destroy();
            }
        }
    });

    ExerPlan.grid.Workouts.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.grid.Workouts, MODx.grid.Grid, {
    getMenu: function() {
        return [{
                text: _('exerplan.update'),
                handler: this.updateWorkout
            }, {
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
                action: 'mgr/workouts/remove',
                id: this.menu.record.id
            },
            listeners: {
                'success': {
                    fn: this.refresh,
                    scope: this
                }
            }
        });
    },
    updateWorkout: function(btn, e) {
        if (!this.updateWorkoutWindow) {
            this.updateWorkoutWindow = MODx.load({
                xtype: 'exerplan-window-workout',
                title: _('exerplan.workout_update'),
                baseParams: {
                    action: 'mgr/workouts/update'
                },
                record: this.menu.record,
                listeners: {
                    'success': {
                        fn: this.refresh,
                        scope: this
                    }
                }
            });
        }
        this.updateWorkoutWindow.setValues(this.menu.record);
        this.updateWorkoutWindow.show(e.target);
    }
});
Ext.reg('exerplan-grid-workouts', ExerPlan.grid.Workouts);