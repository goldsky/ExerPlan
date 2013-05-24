ExerPlan.grid.UserAssessments = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'exerplan-grid-user-assessments',
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/assessments/getList',
            created_for: config.node.attributes.uid
        },
        fields: ['id', 'assessment', 'created_by', 'created_for', 'created_on', 'is_hidden'],
        paging: true,
        remoteSort: true,
        autoExpandColumn: 'assessment',
        save_action: 'mgr/assessments/updateFromGrid',
        autosave: true,
        columns: [
            {
                header: _('id'),
                dataIndex: 'id',
                sortable: true,
                hidden: true,
                width: 40
            }, {
                header: _('exerplan.assessment'),
                dataIndex: 'assessment',
                sortable: false,
                editor: {
                    xtype: 'textarea'
//                    xtype: 'htmleditor',
//                    enableAlignments: false,
//                    enableColors: false,
//                    enableFont: false,
//                    enableFontSize: false
                }
            }, {
                xtype: 'checkcolumn',
                header: _('exerplan.hidden'),
                dataIndex: 'is_hidden',
                width: 30,
                sortable: false,
                processEvent: function(name, e, grid, rowIndex, colIndex) {
                    if (name === 'mousedown') {
                        var record = grid.store.getAt(rowIndex);
                        record.set(this.dataIndex, !record.data[this.dataIndex]);
                        MODx.Ajax.request({
                            url: ExerPlan.config.connectorUrl,
                            params: {
                                action: 'mgr/assessments/updateFromGrid',
                                data: JSON.stringify(record.data)
                            },
                            listeners: {
                                'success': {
                                    fn: function() {
                                        Ext.getCmp('exerplan-grid-user-assessments').refresh();
                                    }
                                }
                            }
                        });
                        return false;
                    } else {
                        return Ext.grid.ActionColumn.superclass.processEvent.apply(this, arguments);
                    }
                }
            }
        ],
        tbar: [{
                text: _('exerplan.assess_create'),
                handler: {
                    xtype: 'exerplan-window-assessment',
                    baseParams: {
                        action: 'mgr/assessments/create',
                        created_for: config.node.attributes.uid
                    },
                    blankValues: true
                }
            }
        ]
    });

    ExerPlan.grid.UserAssessments.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.grid.UserAssessments, MODx.grid.Grid, {
    getMenu: function() {
        return [{
                text: _('exerplan.update'),
                handler: this.updateAssessment
            }, {
                text: _('exerplan.remove'),
                handler: this.removeAssessment
            }];
    },
    updateAssessment: function(btn, e) {
        if (!this.updateAssessmentWindow) {
            this.updateAssessmentWindow = MODx.load({
                xtype: 'exerplan-window-assessment',
                title: _('exerplan.update'),
                baseParams: {
                    action: 'mgr/assessments/update',
                    id: this.menu.record.id
                },
                listeners: {
                    'success': {
                        fn: this.refresh,
                        scope: this
                    }
                }
            });
        }

        this.updateAssessmentWindow.setValues(this.menu.record);
        this.updateAssessmentWindow.show(e.target);
    },
    removeAssessment: function() {
        MODx.msg.confirm({
            title: _('exerplan.assess_remove'),
            text: _('exerplan.assess_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/assessments/remove',
                id: this.menu.record.id
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
Ext.reg('exerplan-grid-user-assessments', ExerPlan.grid.UserAssessments);


ExerPlan.window.Assessment = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('exerplan.assess_create'),
        url: ExerPlan.config.connectorUrl,
        fields: [
            {
                xtype: 'hidden',
                name: 'id'
            }, {
                xtype: 'htmleditor',
                fieldLabel: _('exerplan.assessment'),
                name: 'assessment',
                anchor: '100%',
                enableAlignments: false,
                enableColors: false,
                enableFont: false,
                enableFontSize: false
            }, {
                xtype: 'xcheckbox',
                boxLabel: _('exerplan.hidden'),
                name: 'is_hidden'
            }]
    });

    ExerPlan.window.Assessment.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.window.Assessment, MODx.Window);
Ext.reg('exerplan-window-assessment', ExerPlan.window.Assessment);