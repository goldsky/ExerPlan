ExerPlan.combo.GalleryMediatypes = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        url: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/galleries/mediatypes/getList'
        },
        fields: ['id', 'mediatype'],
        name: 'mediatype_id',
        hiddenName: 'mediatype_id',
        displayField: 'mediatype',
        valueField: 'id',
        typeAhead: false,
        triggerAction: 'all',
        lazyRender: true,
        emptyText: _('exerplan.select...')
    });
    ExerPlan.combo.GalleryMediatypes.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.combo.GalleryMediatypes, MODx.combo.ComboBox);
Ext.reg('exerplan-combo-gallery-mediatypes', ExerPlan.combo.GalleryMediatypes);