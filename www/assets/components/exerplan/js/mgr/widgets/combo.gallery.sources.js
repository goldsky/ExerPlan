ExerPlan.combo.GallerySources = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/galleries/sources/getList'
        },
        fields: ['id', 'source'],
        name: 'source_id',
        hiddenName: 'source_id',
        displayField: 'source',
        valueField: 'id',
        typeAhead: false,
        triggerAction: 'all',
        lazyRender: true,
        emptyText: _('exerplan.select...')
    });
    ExerPlan.combo.GallerySources.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.combo.GallerySources, MODx.combo.ComboBox);
Ext.reg('exerplan-combo-gallery-sources', ExerPlan.combo.GallerySources);