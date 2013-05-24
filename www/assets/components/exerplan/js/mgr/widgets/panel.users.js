ExerPlan.panel.Users = function(config) {
    config = config || {};

    var name = config.node.attributes.fullname ?
            config.node.attributes.fullname + ' (' + config.node.attributes.username + ')' :
            config.node.attributes.username;
    Ext.applyIf(config, {
        id: 'exerplan-panel-users',
        border: false,
        defaults: {
            border: false,
            autoHeight: true
        },
        items: [
            {
                xtype: 'modx-tabs',
                autoHeight: true,
                deferredRender: false,
                forceLayout: true,
                width: '98%',
                padding: 10,
                border: true,
                defaults: {
                    border: false,
                    autoHeight: true,
                    padding: '5 8 5 5',
                    layout: 'form',
                    deferredRender: false,
                    forceLayout: true
                },
                items: [
                    {
                        title: _('exerplan.workouts'),
                        defaults: {
                            border: false,
                            autoHeight: true
                        },
                        items: [
                            {
                                html: '<h3>' + _('exerplan.workouts.user') + ': ' + name + '</h3>'
                            }, {
                                id: 'exerplan-panel-workouts-user-usergroups'
                            }, {
                                autoEl: {
                                    tag: 'br'
                                }
                            }, {
                                html: '<h3>' + _('exerplan.individual_workouts') + '</h3>'
                            }, {
                                xtype: 'exerplan-grid-workouts-user',
                                node: config.node
                            }
                        ]
                    }, {
                        title: _('exerplan.user.galleries'),
                        items: [
                            {
                                html: _('exerplan.user.galleries_desc'),
                                bodyCssClass: 'panel-desc'
                            }, {
                                xtype: 'exerplan-grid-user-galleries',
                                node: config.node
                            }
                        ]
                    }, {
                        title: _('exerplan.assessments'),
                        items: [
                            {
                                html: _('exerplan.assessments_desc'),
                                bodyCssClass: 'panel-desc'
                            }, {
                                xtype: 'exerplan-grid-user-assessments',
                                node: config.node
                            }
                        ]
                    }
                ]
            }
        ]
    });
    this.getUsergroupWorkouts(config);

    ExerPlan.panel.Users.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.panel.Users, MODx.Panel, {
    getUsergroupWorkouts: function(config) {
        MODx.Ajax.request({
            url: ExerPlan.config.connectorUrl,
            params: {
                action: 'mgr/users/usergroups',
                user_id: config.node.attributes.uid
            },
            listeners: {
                'success': {
                    fn: function(response) {
                        var userUsergroupsWorkoutHandle = Ext.getCmp('exerplan-panel-workouts-user-usergroups');
                        Ext.each(response.object, function(item, i) {
                            userUsergroupsWorkoutHandle.add({
                                xtype: 'modx-panel',
                                border: false,
                                items: [{
                                        autoEl: {
                                            tag: 'br'
                                        }
                                    }, {
                                        html: '<h3>' + _('exerplan.workouts.usergroup') + ': ' + item.name + '</h3>',
                                        border: false
                                    }, {
                                        xtype: 'exerplan-grid-workouts-user-usergroup',
                                        ugid: item.id
                                    }
                                ]
                            });
                        });

                    },
                    scope: this
                }
            }
        });
    }
});
Ext.reg('exerplan-panel-users', ExerPlan.panel.Users);

ExerPlan.grid.WorkoutsUserUsergroup = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'exerplan-grid-workouts-user-usergroup',
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/workouts/getList',
            usergroup_id: config.ugid
        },
        fields: ['id', 'name', 'description', 'goal', 'level_id', 'level',
            'set', 'repetition', 'rest_time', 'rest_time_unit',
            'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun',
            'timely_rep', 'timely_unit', 'sort'
        ],
        border: false,
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
        ]
    });

    ExerPlan.grid.WorkoutsUserUsergroup.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.grid.WorkoutsUserUsergroup, MODx.grid.Grid);
Ext.reg('exerplan-grid-workouts-user-usergroup', ExerPlan.grid.WorkoutsUserUsergroup);
