ExerPlan.grid.UserGalleries = function(config) {
    config = config || {};

    var comboGallerySources = new ExerPlan.combo.GallerySources();
    if (comboGallerySources.store && !comboGallerySources.store.isLoaded) {
        comboGallerySources.store.load();
        comboGallerySources.store.isLoaded = true;
    }

    var comboGalleryMediatypes = new ExerPlan.combo.GalleryMediatypes();
    if (comboGalleryMediatypes.store && !comboGalleryMediatypes.store.isLoaded) {
        comboGalleryMediatypes.store.load();
        comboGalleryMediatypes.store.isLoaded = true;
    }

    Ext.applyIf(config, {
        id: 'exerplan-grid-user-galleries',
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/galleries/getList',
            user_id: config.node.attributes.uid
        },
        fields: [
            'id', 'workout_id', 'user_id', 'source_id', 'source', 'mediatype_id',
            'mediatype', 'name', 'description', 'url', 'data', 'controller'
        ],
        paging: true,
        remoteSort: true,
        anchor: '100%',
        autoExpandColumn: 'url',
        save_action: 'mgr/galleries/updateFromGrid',
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
                dataIndex: 'source_id',
                sortable: false,
                width: 60,
                editor: comboGallerySources,
                renderer: function(value) {
                    var record = comboGallerySources.findRecord(comboGallerySources.valueField, value);
                    return record ? record.get(comboGallerySources.displayField) : comboGallerySources.valueNotFoundText;
                }
            }, {
                header: _('exerplan.type'),
                dataIndex: 'mediatype_id',
                sortable: false,
                width: 60,
                editor: comboGalleryMediatypes,
                renderer: function(value) {
                    var record = comboGalleryMediatypes.findRecord(comboGalleryMediatypes.valueField, value);
                    return record ? record.get(comboGalleryMediatypes.displayField) : comboGalleryMediatypes.valueNotFoundText;
                }
            }, {
                header: _('exerplan.url'),
                dataIndex: 'url',
                sortable: true,
                editor: {
                    xtype: 'textfield'
                }
            }, {
                header: _('exerplan.name'),
                dataIndex: 'name',
                sortable: true,
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
                editor: {
                    xtype: 'textfield'
                }
            }
        ],
        tbar: ['->', {
                xtype: 'button',
                text: _('exerplan.add'),
                menu: this.getAddMenu()
            }
        ]
    });

    ExerPlan.grid.UserGalleries.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.grid.UserGalleries, MODx.grid.Grid, {
    getMenu: function() {
        return [{
                text: _('exerplan.update'),
                handler: this.updateGallery
            }, {
                text: _('exerplan.remove'),
                handler: this.removeGallery
            }];
    },
    updateGallery: function(btn, e) {
        if (!this.updateGalleryWindow) {
            this.updateGalleryWindow = MODx.load({
                xtype: 'exerplan-window-gallery-url',
                title: _('exerplan.update'),
                baseParams: {
                    action: 'mgr/galleries/update',
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

        this.updateGalleryWindow.setValues(this.menu.record);
        this.updateGalleryWindow.show(e.target);
    },
    removeGallery: function() {
        MODx.msg.confirm({
            title: _('exerplan.gallery_remove'),
            text: _('exerplan.gallery_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/galleries/remove',
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
    getAddMenu: function() {
        var bm = [];
        bm.push({
            text: _('exerplan.url'),
            handler: this.addUrl,
            scope: this
        }/*, {
            text: _('exerplan.open_browser'),
            handler: this.openBrowser,
            scope: this
        }*/);
        return bm;
    },
    addUrl: function(btn, e) {
        if (!this.addUrlWindow) {
            this.addUrlWindow = MODx.load({
                xtype: 'exerplan-window-gallery-url',
                title: _('exerplan.add'),
                baseParams: {
                    action: 'mgr/galleries/create',
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

        this.addUrlWindow.reset();
        this.addUrlWindow.show(e.target);
    },
    openBrowser: function() {
        console.log('this', this);
    }
});
Ext.reg('exerplan-grid-user-galleries', ExerPlan.grid.UserGalleries);
