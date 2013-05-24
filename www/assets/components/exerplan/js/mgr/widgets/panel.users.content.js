ExerPlan.panel.UsersContent = function(config) {
    config = config || {};

    Ext.apply(config,{
        id: 'exerplan-panel-users-content',
        collapsible: false,
        margins: '0 0 0 0',
        cmargins: '0 0 0 0'
    });
    ExerPlan.panel.UsersContent.superclass.constructor.call(this,config);
};

Ext.extend(ExerPlan.panel.UsersContent, MODx.Panel);
Ext.reg('exerplan-panel-users-content', ExerPlan.panel.UsersContent);