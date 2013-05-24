ExerPlan.panel.GalleriesContent = function(config) {
    config = config || {};

    Ext.apply(config,{
        id: 'exerplan-panel-galleries-content',
        collapsible: false,
        margins: '0 0 0 0',
        cmargins: '0 0 0 0'
    });
    ExerPlan.panel.GalleriesContent.superclass.constructor.call(this,config);
};

Ext.extend(ExerPlan.panel.GalleriesContent, MODx.Panel);
Ext.reg('exerplan-panel-galleries-content', ExerPlan.panel.GalleriesContent);