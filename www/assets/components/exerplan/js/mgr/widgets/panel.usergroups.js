ExerPlan.panel.Usersgroups = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'exerplan-panel-usergroups',
        border: false,
        defaults: {
            border: false,
            autoHeight: true
        },
        items: [
            {
                html: '<h3>' + _('exerplan.workouts.usergroup') + ': ' + config.node.text + '</h3>'
            }, {
                xtype: 'exerplan-grid-workouts-usergroup',
                node: config.node
            }
        ]
    });

    ExerPlan.panel.Usersgroups.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.panel.Usersgroups, MODx.Panel);
Ext.reg('exerplan-panel-usergroups', ExerPlan.panel.Usersgroups);