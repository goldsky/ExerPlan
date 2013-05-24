ExerPlan.combo.Workouts = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/workouts/getList'
        },
        fields: ['id', 'name'],
        name: 'id',
        hiddenName: 'id',
        displayField: 'name',
        valueField: 'id',
        typeAhead: false,
        triggerAction: 'all',
        lazyRender: true,
        emptyText: _('exerplan.select...')
    });
    ExerPlan.combo.Workouts.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.combo.Workouts, MODx.combo.ComboBox);
Ext.reg('exerplan-combo-workouts', ExerPlan.combo.Workouts);