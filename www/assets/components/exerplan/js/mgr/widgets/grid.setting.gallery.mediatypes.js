ExerPlan.grid.SettingGalleryMediatypes = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'exerplan-grid-setting-gallery-mediatypes',
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/galleries/mediatypes/getList'
        },
        fields: ['id', 'mediatype', 'description', 'file_extensions'],
        paging: true,
        remoteSort: true,
        anchor: '97%',
        autoExpandColumn: 'description',
        save_action: 'mgr/galleries/mediatypes/updateFromGrid',
        autosave: true,
        columns: [
            {
                header: _('id'),
                dataIndex: 'id',
                sortable: true,
                hidden: true,
                width: 40
            }, {
                header: _('exerplan.mediatype'),
                dataIndex: 'mediatype',
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
                header: _('exerplan.file_extensions'),
                dataIndex: 'file_extensions',
                sortable: false,
                editor: {
                    xtype: 'textfield'
                }
            }
        ],
        tbar: [{
                text: _('exerplan.mediatype_create'),
                handler: {
                    xtype: 'exerplan-window-mediatype-create',
                    blankValues: true
                }
            }
        ]
    });

    ExerPlan.grid.SettingGalleryMediatypes.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.grid.SettingGalleryMediatypes, MODx.grid.Grid, {
    getMenu: function() {
        return [{
                text: _('exerplan.remove'),
                handler: this.removeGalleryMediatypes
            }];
    },
    removeGalleryMediatypes: function() {
        MODx.msg.confirm({
            title: _('exerplan.mediatype_remove'),
            text: _('exerplan.mediatype_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/galleries/mediatypes/remove',
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
Ext.reg('exerplan-grid-setting-gallery-mediatypes', ExerPlan.grid.SettingGalleryMediatypes);

ExerPlan.window.CreateMediatype = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        title: _('exerplan.mediatype_create'),
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/galleries/mediatypes/create'
        },
        fields: [{
                xtype: 'textfield',
                fieldLabel: _('exerplan.mediatype'),
                name: 'mediatype',
                anchor: '100%'
            }, {
                xtype: 'textarea',
                fieldLabel: _('exerplan.description'),
                name: 'description',
                anchor: '100%'
            }, {
                xtype: 'textfield',
                fieldLabel: _('exerplan.file_extensions'),
                name: 'file_extensions',
                anchor: '100%'
            }]
    });
    ExerPlan.window.CreateMediatype.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.window.CreateMediatype, MODx.Window);
Ext.reg('exerplan-window-mediatype-create', ExerPlan.window.CreateMediatype);