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

ExerPlan.window.Workout = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        url: ExerPlan.config.connectorUrl,
        width: 600,
        fields: [{
                xtype: 'hidden',
                name: 'id'
            }, {
                layout: 'column',
                border: false,
                defaults: {
                    border: false,
                    autoHeight: true,
                    layout: 'form',
                    columnWidth: .5,
                    anchor: '100%'
                },
                items: [
                    {
                        items: [
                            {
                                xtype: 'textfield',
                                fieldLabel: _('exerplan.name'),
                                name: 'name',
                                anchor: '100%'
                            }, {
                                xtype: 'textarea',
                                fieldLabel: _('exerplan.description'),
                                name: 'description',
                                anchor: '100%'
                            }, {
                                xtype: 'textarea',
                                fieldLabel: _('exerplan.goal'),
                                name: 'goal',
                                anchor: '100%'
                            }, {
                                fieldLabel: _('exerplan.difficulty_level'),
                                xtype: 'exerplan-combo-levels'
                            }
                        ]
                    }, {
                        items: [
                            {
                                fieldLabel: _('exerplan.sets_number'),
                                xtype: 'numberfield',
                                name: 'set'
                            }, {
                                fieldLabel: _('exerplan.reps_number'),
                                xtype: 'numberfield',
                                name: 'repetition'
                            }, {
                                layout: 'column',
                                columns: 3,
                                items: [
                                    {
                                        html: _('exerplan.rest_for') + ': ',
                                        columnWidth: .33
                                    }, {
                                        xtype: 'numberfield',
                                        columnWidth: .33,
                                        name: 'rest_time'
                                    }, {
                                        xtype: 'combo',
                                        name: 'rest_time_unit',
                                        columnWidth: .33,
                                        triggerAction: 'all',
                                        lazyRender: true,
                                        mode: 'local',
                                        store: new Ext.data.ArrayStore({
                                            fields: [
                                                'value',
                                                'displayText'
                                            ],
                                            data: [
                                                ['minutes', _('exerplan.minutes')],
                                                ['hours', _('exerplan.hours')],
                                                ['days', _('exerplan.days')],
                                                ['months', _('exerplan.months')]
                                            ]
                                        }),
                                        valueField: 'value',
                                        displayField: 'displayText'
                                    }
                                ]
                            }, {
                                xtype: 'checkboxgroup',
                                fieldLabel: _('exerplan.routines'),
                                columns: 2,
                                items: [
                                    {
                                        boxLabel: _('exerplan.monday'),
                                        xtype: 'xcheckbox',
                                        name: 'mon'
                                    }, {
                                        boxLabel: _('exerplan.tuesday'),
                                        xtype: 'xcheckbox',
                                        name: 'tue'
                                    }, {
                                        boxLabel: _('exerplan.wednesday'),
                                        xtype: 'xcheckbox',
                                        name: 'wed'
                                    }, {
                                        boxLabel: _('exerplan.thursday'),
                                        xtype: 'xcheckbox',
                                        name: 'thu'
                                    }, {
                                        boxLabel: _('exerplan.friday'),
                                        xtype: 'xcheckbox',
                                        name: 'fri'
                                    }, {
                                        boxLabel: _('exerplan.saturday'),
                                        xtype: 'xcheckbox',
                                        name: 'sat'
                                    }, {
                                        boxLabel: _('exerplan.sunday'),
                                        xtype: 'xcheckbox',
                                        name: 'sun'
                                    }
                                ]
                            }, {
                                layout: 'column',
                                columns: 3,
                                items: [
                                    {
                                        xtype: 'textfield',
                                        name: 'timely_rep',
                                        columnWidth: .33
                                    }, {
                                        html: ' times per ',
                                        columnWidth: .33
                                    }, {
                                        xtype: 'combo',
                                        name: 'timely_unit',
                                        columnWidth: .33,
                                        triggerAction: 'all',
                                        lazyRender: true,
                                        mode: 'local',
                                        store: new Ext.data.ArrayStore({
                                            fields: [
                                                'value',
                                                'displayText'
                                            ],
                                            data: [
                                                ['daily', _('exerplan.daily')],
                                                ['weekly', _('exerplan.weekly')],
                                                ['monthly', _('exerplan.monthly')],
                                                ['yearly', _('exerplan.yearly')]
                                            ]
                                        }),
                                        valueField: 'value',
                                        displayField: 'displayText'
                                    }
                                ]
                            }
                        ]
                    }
                ]
            }]
    });
    ExerPlan.window.Workout.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.window.Workout, MODx.Window);
Ext.reg('exerplan-window-workout', ExerPlan.window.Workout);

ExerPlan.combo.Levels = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/levels/getList'
        },
        fields: ['id', 'level'],
        name: 'level_id',
        hiddenName: 'level_id',
        displayField: 'level',
        valueField: 'id'
    });
    ExerPlan.combo.Levels.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.combo.Levels, MODx.combo.ComboBox);
Ext.reg('exerplan-combo-levels', ExerPlan.combo.Levels);