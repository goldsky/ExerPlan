ExerPlan.combo.Levels = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/levels/getList'
        },
        fields: ['id', 'level'],
        name: 'level_id',
        hiddenName: 'level_id',
        displayField: 'level',
        valueField: 'id'
    });
    ExerPlan.combo.Levels.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.combo.Levels, MODx.combo.ComboBox);
Ext.reg('exerplan-combo-levels', ExerPlan.combo.Levels);