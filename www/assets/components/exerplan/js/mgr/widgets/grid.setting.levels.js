ExerPlan.grid.SettingLevels = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'exerplan-grid-setting-levels',
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/levels/getList'
        },
        fields: ['id', 'level', 'description', 'sort'],
        paging: true,
        remoteSort: true,
        anchor: '97%',
        autoExpandColumn: 'description',
        save_action: 'mgr/levels/updateFromGrid',
        autosave: true,
        columns: [
            {
                header: _('id'),
                dataIndex: 'id',
                sortable: true,
                hidden: true,
                width: 40
            }, {
                header: _('exerplan.level'),
                dataIndex: 'level',
                sortable: true,
                width: 100,
                editor: {
                    xtype: 'textfield'
                }
            }, {
                header: _('exerplan.description'),
                dataIndex: 'description',
                sortable: false,
                editor: {
                    xtype: 'textarea'
                }
            }, {
                header: _('exerplan.sort'),
                dataIndex: 'sort',
                width: 20,
                sortable: true,
                editor: {
                    xtype: 'numberfield'
                }
            }
        ],
        tbar: [{
                text: _('exerplan.level_create'),
                handler: {
                    xtype: 'exerplan-window-level-create',
                    blankValues: true
                }
            }
        ]
    });

    ExerPlan.grid.SettingLevels.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.grid.SettingLevels, MODx.grid.Grid, {
    getMenu: function() {
        return [{
                text: _('exerplan.remove'),
                handler: this.removeLevel
            }];
    },
    removeLevel: function() {
        MODx.msg.confirm({
            title: _('exerplan.level_remove'),
            text: _('exerplan.level_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/levels/remove',
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
Ext.reg('exerplan-grid-setting-levels', ExerPlan.grid.SettingLevels);

ExerPlan.window.CreateLevel = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        title: _('exerplan.level_create'),
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/levels/create'
        },
        fields: [{
                xtype: 'textfield',
                fieldLabel: _('exerplan.level'),
                name: 'level',
                anchor: '100%'
            }, {
                xtype: 'textarea',
                fieldLabel: _('exerplan.description'),
                name: 'description',
                anchor: '100%'
            }, {
                xtype: 'numberfield',
                fieldLabel: _('exerplan.sort'),
                name: 'sort',
                anchor: '30%'
            }]
    });
    ExerPlan.window.CreateLevel.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.window.CreateLevel, MODx.Window);
Ext.reg('exerplan-window-level-create', ExerPlan.window.CreateLevel);