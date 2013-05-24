ExerPlan.grid.SettingGallerySources = function(config) {
    config = config || {};

    var comboGalleryMediatypes = new ExerPlan.combo.GalleryMediatypes();
    if (comboGalleryMediatypes.store && !comboGalleryMediatypes.store.isLoaded) {
        comboGalleryMediatypes.store.load();
        comboGalleryMediatypes.store.isLoaded = true;
    }

    Ext.applyIf(config, {
        id: 'exerplan-grid-setting-gallery-sources',
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/galleries/sources/getList'
        },
        fields: ['id', 'source', 'mediatype_id', 'mediatype', 'description', 'data', 'controller'],
        paging: true,
        remoteSort: true,
        anchor: '97%',
        autoExpandColumn: 'description',
        save_action: 'mgr/galleries/sources/updateFromGrid',
        autosave: true,
        columns: [
            {
                header: _('id'),
                dataIndex: 'id',
                sortable: true,
                hidden: true,
                width: 40
            }, {
                header: _('exerplan.source'),
                dataIndex: 'source',
                sortable: true,
                width: 100,
                editor: {
                    xtype: 'textfield'
                }
            }, {
                header: _('exerplan.default_mediatype'),
                dataIndex: 'mediatype_id',
                sortable: true,
                width: 100,
                editor: comboGalleryMediatypes,
                renderer: function(value) {
                    var record = comboGalleryMediatypes.findRecord(comboGalleryMediatypes.valueField, value);
                    return record ? record.get(comboGalleryMediatypes.displayField) : comboGalleryMediatypes.valueNotFoundText;
                }
            }, {
                header: _('exerplan.description'),
                dataIndex: 'description',
                sortable: false,
                editor: {
                    xtype: 'textarea'
                }
            }, {
                header: _('exerplan.data'),
                dataIndex: 'data',
                sortable: false,
                hidden: true,
                editor: {
                    xtype: 'textarea'
                }
            }, {
                header: _('exerplan.controller'),
                dataIndex: 'controller',
                sortable: false,
                hidden: true,
                width: 100,
                editor: {
                    xtype: 'textfield'
                }
            }
        ],
        tbar: [{
                text: _('exerplan.source_create'),
                handler: {
                    xtype: 'exerplan-window-gallery-source',
                    title: _('exerplan.source_create'),
                    baseParams: {
                        action: 'mgr/galleries/sources/create'
                    },
                    blankValues: true
                }
            }
        ]
    });

    ExerPlan.grid.SettingGallerySources.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.grid.SettingGallerySources, MODx.grid.Grid, {
    getMenu: function() {
        return [
            {
                text: _('exerplan.update'),
                handler: this.updateGallerySource
            }, {
                text: _('exerplan.remove'),
                handler: this.removeGallerySource
            }];
    },
    updateGallerySource: function(btn, e) {
        if (!this.updateGallerySourceWindow) {
            this.updateGallerySourceWindow = MODx.load({
                xtype: 'exerplan-window-gallery-source',
                title: _('exerplan.update'),
                baseParams: {
                    action: 'mgr/galleries/sources/update',
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

        this.updateGallerySourceWindow.setValues(this.menu.record);
        this.updateGallerySourceWindow.show(e.target);
    },
    removeGallerySource: function() {
        MODx.msg.confirm({
            title: _('exerplan.source_remove'),
            text: _('exerplan.source_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/galleries/sources/remove',
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
Ext.reg('exerplan-grid-setting-gallery-sources', ExerPlan.grid.SettingGallerySources);

ExerPlan.window.GallerySource = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        url: ExerPlan.config.connectorUrl,
        fields: [
            {
                xtype: 'modx-tabs',
                preventRender: true,
                deferredRender: false,
                border: true,
                plain: true,
                defaults: {
                    border: false,
                    autoHeight: true,
                    layout: 'form'
                },
                items: [
                    {
                        title: _('exerplan.source'),
                        activeTab: 0,
                        bodyStyle: 'padding: 15px',
                        items: [
                            {
                                xtype: 'hidden',
                                name: 'id'
                            }, {
                                xtype: 'textfield',
                                fieldLabel: '',
                                name: 'source',
                                anchor: '100%'
                            }, {
                                xtype: 'exerplan-combo-gallery-mediatypes',
                                fieldLabel: _('exerplan.default_mediatype'),
                                name: 'mediatype',
                                anchor: '100%'
                            }, {
                                xtype: 'textarea',
                                fieldLabel: _('exerplan.description'),
                                name: 'description',
                                anchor: '100%'
                            }
                        ]
                    }, {
                        title: _('exerplan.data'),
                        activeTab: 0,
                        bodyStyle: 'padding: 15px',
                        items: [
                            {
                                xtype: 'panel',
                                html: _('exerplan.data_desc')
                            }, {
                                xtype: 'textarea',
                                fieldLabel: '',
                                name: 'data',
                                anchor: '100%',
                                height: 200
                            }, {
                                xtype: 'textfield',
                                fieldLabel: _('exerplan.controller'),
                                name: 'controller',
                                anchor: '100%'
                            }
                        ]
                    }
                ]
            }
        ]
    });
    ExerPlan.window.GallerySource.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.window.GallerySource, MODx.Window);
Ext.reg('exerplan-window-gallery-source', ExerPlan.window.GallerySource);