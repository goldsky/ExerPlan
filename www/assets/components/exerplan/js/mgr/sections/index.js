Ext.onReady(function() {
    MODx.load({
        xtype: 'exerplan-page-home'
    });
});

ExerPlan.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
                xtype: 'exerplan-panel-home',
                renderTo: 'exerplan-panel-home-div'
            }]
    });
    ExerPlan.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan.page.Home, MODx.Component);
Ext.reg('exerplan-page-home', ExerPlan.page.Home);