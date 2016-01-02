Organizations.window.CreateOrg = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-orgs-window-create';
	}
	Ext.applyIf(config, {
		title: _('organizations_orgs_create'),
		width: 800,
		autoHeight: true,
		url: Organizations.config.connector_url,
		action: 'mgr/orgs/create',
		layout: 'column',
		defaults: {
			xtype: 'form',
			columnWidth:0.5,
			labelAlign: 'top',
			anchor: '100%'
		},
		items: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}]
	});
	Organizations.window.CreateOrg.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.window.CreateOrg, MODx.Window, {

	getFields: function (config) {
		//console.info(config);
		//console.info('Organizations.config.org_fields',Organizations.config.org_fields);
		//return Organizations.config.org_fields;
		return [{
			items:[{
					xtype: 'textfield',
					fieldLabel: _('organizations_grid_shortname'),
					name: 'name',
					id: config.id + '-name',
					anchor: '99%',
					allowBlank: false,
				}, {
					xtype: 'textarea',
					fieldLabel: _('organizations_orgs_description'),
					name: 'description',
					id: config.id + '-description',
					height: 150,
					anchor: '99%'
				}]
		}, {
			items:[{
					xtype: 'textfield',
					fieldLabel: _('organizations_grid_shortname'),
					name: 'name1',
					id: config.id + '-1name',
					anchor: '99%',
					allowBlank: false,
				}, {
					xtype: 'textarea',
					fieldLabel: _('organizations_orgs_description'),
					name: 'description1',
					id: config.id + '-1description',
					height: 150,
					anchor: '99%'
			}]
			
		}];
	},

	loadDropZones: function() {
	}

});
Ext.reg('organizations-orgs-window-create', Organizations.window.CreateOrg);


Organizations.window.UpdateOrg = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-orgs-window-update';
	}
	Ext.applyIf(config, {
		title: _('organizations_orgs_update'),
		width: 550,
		autoHeight: true,
		url: Organizations.config.connector_url,
		action: 'mgr/orgs/update',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}]
	});
	Organizations.window.UpdateOrg.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.window.UpdateOrg, MODx.Window, {

	getFields: function (config) {
		return [{
			xtype: 'hidden',
			name: 'id',
			id: config.id + '-id',
		}, {
			xtype: 'textfield',
			fieldLabel: _('organizations_orgs_name'),
			name: 'name',
			id: config.id + '-name',
			anchor: '99%',
			allowBlank: false,
		}, {
			xtype: 'textarea',
			fieldLabel: _('organizations_orgs_description'),
			name: 'description',
			id: config.id + '-description',
			anchor: '99%',
			height: 150,
		}, {
			xtype: 'xcheckbox',
			boxLabel: _('organizations_orgs_active'),
			name: 'active',
			id: config.id + '-active',
		}];
	},

	loadDropZones: function() {
	}

});
Ext.reg('organizations-orgs-window-update', Organizations.window.UpdateOrg);