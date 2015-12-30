var Organizations = function (config) {
	config = config || {};
	Organizations.superclass.constructor.call(this, config);
};
Ext.extend(Organizations, Ext.Component, {
	page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('organizations', Organizations);

Organizations = new Organizations();