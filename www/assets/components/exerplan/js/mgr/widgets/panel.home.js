ExerPlan.panel.Home = function(config) {
    config = config || {};

    Ext.apply(config, {
        id: 'exerplan-panel-home',
        baseCls: 'modx-formpanel',
        cls: 'container',
        layout: 'border',
        defaults: {
            collapsible: false,
            bodyStyle: 'padding: 15px',
            border: false,
            autoHeight: true
        },
        bodyStyle: 'min-height: 500px;',
        items: [
            {
                html: '<span style="font-weight: bold;">' + _('exerplan') + '</span> ' + ExerPlan.config.version,
                region: 'north'
            }, {
                region: 'center',
                xtype: 'modx-tabs',
                preventRender: true,
                deferredRender: false,
                border: true,
                plain: true,
                defaults: {
                    border: false,
                    autoHeight: true
                },
                items: [
                    {
                        title: _('exerplan.users'),
                        activeTab: 0,
                        defaults: {
                            border: false,
                            autoHeight: true
                        },
                        items: [
                            {
                                html: '<p>' + _('exerplan.workouts.users_desc') + '</p>',
                                bodyCssClass: 'panel-desc'
                            }, {
                                layout: 'border',
                                bodyStyle: 'min-height:600px;',
                                autoHeight: true,
                                defaults: {
                                    collapsible: false,
                                    split: true,
                                    bodyStyle: 'overflow: auto;',
                                    border: false
                                },
                                items: [{
                                        xtype: 'exerplan-tree-users',
                                        id: 'exerplan-tree-users',
                                        bodyStyle: 'padding: 5px;',
                                        collapsible: true,
                                        preventRender: true,
                                        region: 'west',
                                        margins: '0 0 0 0',
                                        cmargins: '0 0 0 5',
                                        width: 300
                                    }, {
                                        xtype: 'exerplan-panel-users-content',
                                        bodyStyle: 'padding: 10px; overflow: auto;',
                                        preventRender: true,
                                        region: 'center',
                                        margins: '5 5 0 0'
                                    }
                                ]
                            }
                        ]
                    }, {
                        title: _('exerplan.workouts'),
                        id: 'exerplan-workouts',
                        activeTab: 1,
                        defaults: {
                            border: false,
                            autoHeight: true
                        },
                        items: [
                            {
//                                xtype: 'exerplan-panel-workouts-galleries',
                                xtype: 'exerplan-panel-workouts-grid',
                                preventRender: true
                            }
                        ]
                    }, {
                        title: _('exerplan.settings'),
                        activeTab: 2,
                        defaults: {
                            border: false,
                            autoHeight: true
                        },
                        items: [
                            {
                                html: '<p>' + _('exerplan.settings_desc') + '</p>',
                                bodyCssClass: 'panel-desc'
                            }, {
                                defaults: {
                                    border: false,
                                    preventRender: true
                                },
                                bodyStyle: 'min-height:600px;',
                                items: [
                                    {
                                        html: '<h3>' + _('exerplan.difficulty_levels') + '</h3>'
                                    }, {
                                        xtype: 'exerplan-grid-setting-levels'
                                    }, {
                                        autoEl: {
                                            tag: 'br'
                                        }
                                    }, {
                                        html: '<h3>' + _('exerplan.gallery_sources') + '</h3>'
                                    }, {
                                        xtype: 'exerplan-grid-setting-gallery-sources'
                                    }, {
                                        autoEl: {
                                            tag: 'br'
                                        }
                                    }, {
                                        html: '<h3>' + _('exerplan.gallery_mediatypes') + '</h3>'
                                    }, {
                                        xtype: 'exerplan-grid-setting-gallery-mediatypes'
                                    }
                                ]
                            }
                        ]
                    }
                ],
                listeners: {
                    afterrender: function(panel) {
                        panel.doLayout();
                    }
                }
            }, {
                html: '<a href="javascript:void(0);" style="color: #bbbbbb;" id="exerplan_about">' +
                        _('exerplan.about') +
                        '</a>',
                region: 'south',
                bodyStyle: 'position: fixed; bottom: 0; font-size: 10px;',
                minSize: 100,
                maxSize: 200,
                margins: '0 0 0 0',
                listeners: {
                    afterrender: function() {
                        Ext.get('exerplan_about').on('click', function() {
                            var msg = '&copy; 2013, ';
                            msg += '<a href="http://www.virtudraft.com" target="_blank">';
                            msg += 'www.virtudraft.com';
                            msg += '</a><br/>';
                            msg += 'License <a href="http://www.gnu.org/licenses/gpl-3.0.html" target="_blank">';
                            msg += 'GPL v3</a>';
                            Ext.MessageBox.alert('ExerPlan', msg);
                        });
                    }
                }
            }
        ]
    });

    Ext.getCmp('modx-content').doLayout();
    ExerPlan.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.panel.Home, MODx.Panel);
Ext.reg('exerplan-panel-home', ExerPlan.panel.Home);