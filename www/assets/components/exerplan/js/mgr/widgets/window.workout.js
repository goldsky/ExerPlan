ExerPlan.window.Workout = function(config) {
    config = config || {};

    console.log('config', config);

    Ext.applyIf(config, {
        url: ExerPlan.config.connectorUrl,
        width: 600,
        preventRender: false,
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
                                defaults: {
                                    xtype: 'xcheckbox'
                                },
                                items: [
                                    {
                                        boxLabel: _('exerplan.monday'),
                                        name: 'mon'
                                    }, {
                                        boxLabel: _('exerplan.tuesday'),
                                        name: 'tue'
                                    }, {
                                        boxLabel: _('exerplan.wednesday'),
                                        name: 'wed'
                                    }, {
                                        boxLabel: _('exerplan.thursday'),
                                        name: 'thu'
                                    }, {
                                        boxLabel: _('exerplan.friday'),
                                        name: 'fri'
                                    }, {
                                        boxLabel: _('exerplan.saturday'),
                                        name: 'sat'
                                    }, {
                                        boxLabel: _('exerplan.sunday'),
                                        name: 'sun'
                                    }
                                ],
								listeners: {
									'render': {
										fn: function() {
											// for initial loading
											if (this.record)
												this.setValues(this.record);
										},
                                        scope: this
									}
								}
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