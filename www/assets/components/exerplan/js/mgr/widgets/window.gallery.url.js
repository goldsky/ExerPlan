ExerPlan.window.galleryUrl = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        // DON'T USE ID!!
        // Let the ExtJs defines this, for multiplication windows
        // on the user tab and workout tab
        // id: 'exerplan-window-gallery-url',
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
                        title: _('exerplan.url'),
                        activeTab: 0,
                        bodyStyle: 'padding: 15px',
                        defaults: {
                            border: false
                        },
                        items: [
                            {
                                xtype: 'hidden',
                                name: 'id'
                            }, {
                                layout: 'hbox',
                                defaults: {
                                    flex: 1,
                                    layout: 'form'
                                },
                                items: [
                                    {
                                        items: [
                                            {
                                                fieldLabel: _('exerplan.gallery.source'),
                                                xtype: 'exerplan-combo-gallery-sources'
                                            }
                                        ]
                                    }, {
                                        items: [
                                            {
                                                fieldLabel: _('exerplan.gallery.mediatype'),
                                                xtype: 'exerplan-combo-gallery-mediatypes'
                                            }
                                        ]
                                    }
                                ]
                            }, {
                                xtype: 'textfield',
                                fieldLabel: _('exerplan.url'),
                                name: 'url',
                                anchor: '100%',
                                allowBlank: false
                            }, {
                                xtype: 'textfield',
                                fieldLabel: _('exerplan.name'),
                                name: 'name',
                                anchor: '100%',
                                allowBlank: false
                            }, {
                                xtype: 'textarea',
                                fieldLabel: _('exerplan.description'),
                                name: 'description',
                                anchor: '100%',
                                height: 100,
                                listeners: {
                                    afterrender: function() {
                                        this.el.swallowEvent(['keypress', 'keydown']);
                                    }
                                }
                            }
                        ]
                    }, {
                        title: _('exerplan.data'),
                        activeTab: 1,
                        bodyStyle: 'padding: 15px',
                        defaults: {
                            border: false
                        },
                        items: [
                            {
                                html: _('exerplan.data_desc')
                            },
                            {
                                xtype: 'textarea',
                                name: 'data',
                                anchor: '100%',
                                height: 200,
                                listeners: {
                                    afterrender: function() {
                                        this.el.swallowEvent(['keypress', 'keydown']);
                                    }
                                }
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
    ExerPlan.window.galleryUrl.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.window.galleryUrl, MODx.Window);
Ext.reg('exerplan-window-gallery-url', ExerPlan.window.galleryUrl);