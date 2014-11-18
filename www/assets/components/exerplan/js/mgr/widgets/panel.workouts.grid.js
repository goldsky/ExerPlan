ExerPlan.panel.WorkoutsGrid = function(config) {
    config = config || {};

    Ext.apply(config, {
        id: 'exerplan-panel-workouts-grid',
        baseCls: 'modx-formpanel',
        cls: 'container',
        defaults: {
            collapsible: false,
            bodyStyle: 'padding: 15px',
            border: false,
            autoHeight: true
        },
        items: [
            {
                html: '<p>' + _('exerplan.workouts_desc') + '</p>',
                bodyCssClass: 'panel-desc'
            }, {
                xtype: 'exerplan-grid-workouts',
                preventRender: true
            }
        ]
    });
    ExerPlan.panel.WorkoutsGrid.superclass.constructor.call(this, config);

    var workoutsHandler = Ext.getCmp('exerplan-workouts');
    workoutsHandler.removeAll(true);
    workoutsHandler.add(this);
    var container = Ext.getCmp('modx-content');
    container.doLayout();

};

Ext.extend(ExerPlan.panel.WorkoutsGrid, MODx.Panel);
Ext.reg('exerplan-panel-workouts-grid', ExerPlan.panel.WorkoutsGrid);