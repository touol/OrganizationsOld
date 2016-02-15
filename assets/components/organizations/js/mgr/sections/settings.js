Organizations.page.Settings = function (config) {
	config = config || {};
	Ext.applyIf(config, {
		components: [{
			xtype: 'organizations-panel-settings', renderTo: 'organizations-panel-home-div'
		}]
	});
	Organizations.page.Settings.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.page.Settings, MODx.Component);
Ext.reg('organizations-page-settings', Organizations.page.Settings);