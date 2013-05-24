ExerPlan.panel.Galleries = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'exerplan-panel-galleries',
        border: false,
        defaults: {
            border: false,
            autoHeight: true
        },
        items: [
            {
                html: '<h3>' + _('exerplan.workout') + ': ' + config.node.text + '</h3>'
            }, {
                xtype: 'exerplan-grid-workout-galleries',
                node: config.node
            }
        ]
    });

    ExerPlan.panel.Galleries.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.panel.Galleries, MODx.Panel, {
});
Ext.reg('exerplan-panel-galleries', ExerPlan.panel.Galleries);
