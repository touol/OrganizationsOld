Organizations.page.Home = function (config) {
	config = config || {};
	Ext.applyIf(config, {
		components: [{
			xtype: 'organizations-panel-home', renderTo: 'organizations-panel-home-div'
		}]
	});
	Organizations.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.page.Home, MODx.Component);
Ext.reg('organizations-page-home', Organizations.page.Home);