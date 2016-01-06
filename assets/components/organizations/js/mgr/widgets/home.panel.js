Organizations.panel.Home = function (config) {
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
				title: _('organizations_orgs'),
				layout: 'anchor',
				items: [{
					xtype: 'organizations-grid-orgs',
					cls: 'main-wrapper',
				}]
			},{
				title: _('organizations_org_users'),
				layout: 'anchor',
				items: [{
					xtype: 'organizations-grid-users',
					cls: 'main-wrapper',
					id:config.id + '-' + 'grid-users'
				}]
			},{
				title: _('organizations_setting'),
				layout: 'anchor',
				items: [{
					xtype: 'organizations-grid-fields',
					cls: 'main-wrapper',
				}]
			}]
		}]
	});
	Organizations.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.panel.Home, MODx.Panel);
Ext.reg('organizations-panel-home', Organizations.panel.Home);
