ExerPlan.panel.WorkoutsGalleries = function(config) {
    config = config || {};

    Ext.apply(config, {
        id: 'exerplan-panel-workouts-galleries',
        baseCls: 'modx-formpanel',
        cls: 'container',
        layout: 'border',
        defaults: {
            collapsible: false,
            bodyStyle: 'padding: 15px',
            border: false,
            autoHeight: true
        },
        bodyStyle: 'min-height: 600px;',
        items: [
            {
                region: 'north',
                html: '<p>' + _('exerplan.manage_galleries_desc') + '</p>',
                bodyCssClass: 'panel-desc'
            }, {
                region: 'center',
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
                        xtype: 'exerplan-tree-workouts',
                        region: 'west',
                        id: 'exerplan-tree-workouts',
                        bodyStyle: 'padding: 5px;',
                        collapsible: true,
                        preventRender: true,
                        margins: '0 0 0 0',
                        cmargins: '0 0 0 5',
                        width: 300
                    }, {
                        region: 'north',
                        height: 32,
                        xtype: 'panel',
                        preventRender: true,
                        layout: 'hbox',
                        layoutConfig: {
                            pack: 'end',
                            align: 'middle'
                        },
                        defaults: {
                            margins: '0 2 0 0'
                        },
                        items: [
                            {
                                xtype: 'button',
                                id: 'exerplan-panel-workouts-grid-button',
                                text: _('exerplan.back_to_workouts_table'),
//                                handler: {
//                                    xtype: 'exerplan-panel-workouts-grid',
//                                    preventRender: true
//                                }
                                handler: function() {
                                    var workoutsGrid = new ExerPlan.panel.WorkoutsGrid(config);
                                    return workoutsGrid.show();
                                }
                            }
                        ]
                    }, {
                        region: 'center',
                        xtype: 'exerplan-panel-galleries-content',
                        bodyStyle: 'overflow: auto;',
                        preventRender: true
                    }
                ]
            }
        ]
    });
    ExerPlan.panel.WorkoutsGalleries.superclass.constructor.call(this, config);

    var workoutsHandler = Ext.getCmp('exerplan-workouts');
    workoutsHandler.removeAll(true);
    workoutsHandler.add(this);
    workoutsHandler.doLayout();

};

Ext.extend(ExerPlan.panel.WorkoutsGalleries, MODx.Panel);
Ext.reg('exerplan-panel-workouts-galleries', ExerPlan.panel.WorkoutsGalleries);