ExerPlan.panel.WorkoutsGrid = function(config) {
    config = config || {};

    Ext.apply(config, {
        id: 'exerplan-panel-workouts-grid',
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
                html: '<p>' + _('exerplan.workouts_desc') + '</p>',
                bodyCssClass: 'panel-desc'
            }, {
                region: 'center',
                xtype: 'exerplan-grid-workouts',
                preventRender: true
            }
        ]
    });
    ExerPlan.panel.WorkoutsGrid.superclass.constructor.call(this, config);

    var workoutsHandler = Ext.getCmp('exerplan-workouts');
    workoutsHandler.removeAll();
    workoutsHandler.add(this);
    workoutsHandler.doLayout();

};

Ext.extend(ExerPlan.panel.WorkoutsGrid, MODx.Panel);
Ext.reg('exerplan-panel-workouts-grid', ExerPlan.panel.WorkoutsGrid);