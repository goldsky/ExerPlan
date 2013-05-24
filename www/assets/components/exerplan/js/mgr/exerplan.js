var ExerPlan = function(config) {
	config = config || {};
	ExerPlan.superclass.constructor.call(this, config);
};
Ext.extend(ExerPlan, Ext.Component, {
	page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}
});
Ext.reg('exerplan', ExerPlan);
ExerPlan = new ExerPlan();