Organizations.panel.Settings = function (config) {
	config = config || {};
	Ext.apply(config, {
		baseCls: 'modx-formpanel',
		layout: 'anchor',
		/*
		 stateful: true,
		 stateId: 'organizations-panel-home',
		 stateEvents: ['tabchange'],
		 getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
		 */
		hideMode: 'offsets',
		items: [{
			html: '<h2>' + _('organizations') + '</h2>',
			cls: '',
			style: {margin: '15px 0'}
		}, {
			xtype: 'modx-tabs',
			defaults: {border: false, autoHeight: true},
			border: true,
			hideMode: 'offsets',
			items: [{
				title: _('organizations_setting_fields'),
				layout: 'anchor',
				items: [{
					xtype: 'organizations-grid-fields',
					cls: 'main-wrapper',
					id:config.id + '-' + 'grid-fields'
				}]
			},{
				title: _('organizations_setting_groups'),
				layout: 'anchor',
				items: [{
					xtype: 'organizations-grid-groups',
					//xtype: 'organizations-grid-access',
					cls: 'main-wrapper',
					id:config.id + '-' + 'grid-groups'
				}]
			}]
		}]
	});
	Organizations.panel.Settings.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.panel.Settings, MODx.Panel);
Ext.reg('organizations-panel-settings', Organizations.panel.Settings);
