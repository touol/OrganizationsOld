Organizations.grid.Groups = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-grid-groups';
	}

	Ext.applyIf(config, {
		url: Organizations.config.connector_url,
		fields: this.getFields(config),
		columns: this.getColumns(config),
		tbar: this.getTopBar(config),
		sm: new Ext.grid.CheckboxSelectionModel(),
		baseParams: {
			action: 'mgr/groups/getlist',
		},
		viewConfig: {
			forceFit: true,
			enableRowBody: true,
			autoFill: true,
			showPreview: true,
			scrollOffset: 0,
		},
		paging: true,
		remoteSort: true,
		autoHeight: true,
	});
	Organizations.grid.Groups.superclass.constructor.call(this, config);
	// Clear selection on grid refresh
	this.store.on('load', function () {
		if (this._getSelectedIds().length) {
			this.getSelectionModel().clearSelections();
		}
	}, this);

};
Ext.extend(Organizations.grid.Groups, MODx.grid.Grid, {
	windows: {},
	getMenu: function (grid, rowIndex) {
		var ids = this._getSelectedIds();

		var row = grid.getStore().getAt(rowIndex);
		var menu = Organizations.utils.getMenu(row.data['actions'], this, ids);

		this.addContextMenuItem(menu);
	},
	onClick: function (e) {
		var elem = e.getTarget();
		if (elem.nodeName == 'BUTTON') {
			var row = this.getSelectionModel().getSelected();
			if (typeof(row) != 'undefined') {
				var action = elem.getAttribute('action');
				if (action == 'showMenu') {
					var ri = this.getStore().find('id', row.id);
					return this._showMenu(this, ri, e);
				}
				else if (typeof this[action] === 'function') {
					this.menu.record = row.data;
					return this[action](this, e);
				}
			}
		}
		return this.processEvent('click', e);
	},
	createGroup: function (btn, e) {
		var w = MODx.load({
			xtype: 'organizations-group-window-create',
			id: Ext.id(),
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		});
		w.reset();
		w.setValues({active: true});
		w.show(e.target);
	},
	updateGroup: function (btn, e, row) {
		if (typeof(row) != 'undefined') {
			this.menu.record = row.data;
		}
		else if (!this.menu.record) {
			return false;
		}

		var w = MODx.load({
			xtype: 'organizations-group-window-update',
			id: Ext.id(),
			record: this.menu.record,
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		});
		w.reset();
		w.setValues(this.menu.record);
		w.show(e.target);
	},
	removeGroup: function (act, btn, e) {
		var ids = this._getSelectedIds();
		if (!ids.length) {
			return false;
		}
		MODx.msg.confirm({
			title: ids.length > 1
				? _('organizations_groups_remove')
				: _('organizations_group_remove'),
			text: ids.length > 1
				? _('organizations_groups_remove_confirm')
				: _('organizations_group_remove_confirm'),
			url: this.config.url,
			params: {
				action: 'mgr/groups/remove',
				ids: Ext.util.JSON.encode(ids),
			},
			listeners: {
				success: {
					fn: function (r) {
						this.refresh();
					}, scope: this
				}
			}
		});
		return true;
	},
	getFields: function (config) {
		return ['id', 'name', 'description', 'data', 'actions'];
	},
	getColumns: function (config) {
		return [{
			header: _('organizations_fields_id'),
			dataIndex: 'id',
			sortable: true,
			width: 70
		}, {
			header: _('organizations_groups_name'),
			dataIndex: 'name',
			sortable: true,
			width: 120,
			//editor: {xtype: 'textfield'},
		}, {
			header: _('organizations_groups_description'),
			dataIndex: 'description',
			sortable: false,
			width: 200,
			//editor: {xtype: 'textfield'},
		}, {
			/* header: _('organizations_groups_data'),
			dataIndex: 'data',
			sortable: false,
			width: 100,
			editor: {xtype: 'textfield'},
		},{ */
			header: _('organizations_grid_actions'),
			dataIndex: 'actions',
			renderer: Organizations.utils.renderActions,
			sortable: false,
			width: 100,
			id: 'actions'
		}];
	},
	getTopBar: function (config) {
		return [{
			text: '<i class="icon icon-plus"></i>&nbsp;' + _('organizations_group_create'),
			handler: this.createGroup,
			scope: this
		}];
	},
	_getSelectedIds: function () {
		var ids = [];
		var selected = this.getSelectionModel().getSelections();

		for (var i in selected) {
			if (!selected.hasOwnProperty(i)) {
				continue;
			}
			ids.push(selected[i]['id']);
		}

		return ids;
	},
});
Ext.reg('organizations-grid-groups', Organizations.grid.Groups);

Organizations.window.CreateGroup = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-group-window-create';
	}
	Ext.applyIf(config, {
		title: _('organizations_group_create'),
		width: 900,
		height: 500,
		url: Organizations.config.connector_url,
		action: 'mgr/groups/create',
		layout: 'anchor',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}],
	});
	Organizations.window.CreateGroup.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.window.CreateGroup, MODx.Window, {
	windows: {},
	submit: function(close) {
		close = close === false ? false : true;
        var f = this.fp.getForm();
		var g = Ext.getCmp(this.config.id + '-' + 'access');
        var p = g.getStore().getRange();
        var rs = {};
        for (var i=0;i<p.length;i++) {
            if(p[i].data['enabled']){
				rs[p[i].data['name']] = true;
			}
        }
		Ext.apply(f.baseParams,{
            data: g ? Ext.encode(rs) : {}
        });
        if (f.isValid()) {
			f.submit({
                waitMsg: _('saving')
                ,scope: this
                ,failure: function(frm,a) {
                    if (this.fireEvent('failure',{f:frm,a:a})) {
                        MODx.form.Handler.errorExt(a.result,frm);
                    }
                    this.doLayout();
                }
                ,success: function(frm,a) {
                    if (this.config.success) {
                        Ext.callback(this.config.success,this.config.scope || this,[frm,a]);
                    }
                    this.fireEvent('success',{f:frm,a:a});
                    if (close) { this.config.closeAction !== 'close' ? this.hide() : this.close(); }
                    this.doLayout();
                }
            });
        }
    },
	getFields: function (config) {
		return [{
				xtype: 'textfield',
				fieldLabel: _('organizations_groups_name'),
				name: 'name',
				id: config.id + '-' + 'name',
				anchor: '99%'
			},{
				xtype: 'textarea',
				fieldLabel: _('organizations_groups_description'),
				name: 'description',
				id: config.id + '-' + 'description',
				anchor: '99%'
			},{
				xtype: 'organizations-grid-access',
				fieldLabel: _('organizations_grid_access'),
				
				id: config.id + '-' + 'access',
				anchor: '99%'
			}];
	},
});
Ext.reg('organizations-group-window-create', Organizations.window.CreateGroup);

Organizations.window.UpdateGroup = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-group-window-update';
	}
	Ext.applyIf(config, {
		title: _('organizations_group_update'),
		width: 900,
		height: 500,
		url: Organizations.config.connector_url,
		action: 'mgr/groups/update',
		layout: 'anchor',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}],
	});
	Organizations.window.UpdateGroup.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.window.UpdateGroup, MODx.Window, {
	windows: {},
	submit: function(close) {
		close = close === false ? false : true;
        var f = this.fp.getForm();
		var g = Ext.getCmp(this.config.id + '-' + 'access');
        var p = g.getStore().getRange();
        var rs = {};
        for (var i=0;i<p.length;i++) {
            if(p[i].data['enabled']){
				rs[p[i].data['name']] = true;
			}
        }
		Ext.apply(f.baseParams,{
            data: g ? Ext.encode(rs) : {}
        });
        if (f.isValid()) {
			f.submit({
                waitMsg: _('saving')
                ,scope: this
                ,failure: function(frm,a) {
                    if (this.fireEvent('failure',{f:frm,a:a})) {
                        MODx.form.Handler.errorExt(a.result,frm);
                    }
                    this.doLayout();
                }
                ,success: function(frm,a) {
                    if (this.config.success) {
                        Ext.callback(this.config.success,this.config.scope || this,[frm,a]);
                    }
                    this.fireEvent('success',{f:frm,a:a});
                    if (close) { this.config.closeAction !== 'close' ? this.hide() : this.close(); }
                    this.doLayout();
                }
            });
        }
    },
	getFields: function (config) {
		return [{
				xtype: 'hidden',
				//fieldLabel: _('organizations_groups_id'),
				name: 'id',
				id: config.id + '-' + 'id',
				anchor: '99%'
			},{
				xtype: 'textfield',
				fieldLabel: _('organizations_groups_name'),
				name: 'name',
				id: config.id + '-' + 'name',
				anchor: '99%'
			},{
				xtype: 'textarea',
				fieldLabel: _('organizations_groups_description'),
				name: 'description',
				id: config.id + '-' + 'description',
				anchor: '99%'
			},{
				xtype: 'organizations-grid-access',
				fieldLabel: _('organizations_grid_access'),
				group_data: config.record.data,
				id: config.id + '-' + 'access',
				anchor: '99%'
			}];
	},
});
Ext.reg('organizations-group-window-update', Organizations.window.UpdateGroup);

Organizations.grid.Access = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-grid-access';
	}
	var ac = new Ext.ux.grid.CheckColumn({
        header: _('enabled')
        ,dataIndex: 'enabled'
        ,width: 80
        ,sortable: false
    });
	Ext.applyIf(config, {
		url: Organizations.config.connector_url,
		fields: ['id', 'name', 'label', 'enabled', 'actions'],
		plugins: ac,
		columns: [{
			header: _('organizations_fields_id'),
			dataIndex: 'id',
			sortable: true,
			width: 70
		}, {
			header: _('organizations_access_name'),
			dataIndex: 'name',
			sortable: true,
			width: 100,
		}, {
			header: _('organizations_access_description'),
			dataIndex: 'label',
			sortable: false,
			width: 200,
		},ac
		,{
			header: _('organizations_grid_actions'),
			dataIndex: 'actions',
			renderer: Organizations.utils.renderActions,
			sortable: false,
			width: 100,
			id: 'actions'
		}],
		tbar: this.getTopBar(config),
		sm: new Ext.grid.CheckboxSelectionModel(),
		baseParams: {
			action: 'mgr/settings/getlist',
			setting: 'org_access',
			group_data: config.group_data
		},
		viewConfig: {
			forceFit: true,
			enableRowBody: true,
			autoFill: true,
			showPreview: true,
			scrollOffset: 0,
		},
		paging: true,
		remoteSort: true,
		autoHeight: true,
	});
	Organizations.grid.Access.superclass.constructor.call(this, config);
	//this.propRecord = new Ext.data.Record.create(['name','description','access','value']);
};
Ext.extend(Organizations.grid.Access, MODx.grid.Grid, {
	getTopBar: function (config) {
		return [{
			text: '<i class="icon icon-plus"></i>&nbsp;' + _('organizations_access_create'),
			handler: this.createAccess,
			scope: this
		}];
	},
	onClick: function (e) {
		var elem = e.getTarget();
		if (elem.nodeName == 'BUTTON') {
			var row = this.getSelectionModel().getSelected();
			if (typeof(row) != 'undefined') {
				var action = elem.getAttribute('action');
				if (action == 'showMenu') {
					var ri = this.getStore().find('id', row.id);
					return this._showMenu(this, ri, e);
				}
				else if (typeof this[action] === 'function') {
					this.menu.record = row.data;
					return this[action](this, e);
				}
			}
		}
		return this.processEvent('click', e);
	},
	getMenu: function (grid, rowIndex) {
		var ids = this._getSelectedIds();

		var row = grid.getStore().getAt(rowIndex);
		var menu = Organizations.utils.getMenu(row.data['actions'], this, ids);

		this.addContextMenuItem(menu);
	},
	_getSelectedIds: function () {
		var ids = [];
		var selected = this.getSelectionModel().getSelections();

		for (var i in selected) {
			if (!selected.hasOwnProperty(i)) {
				continue;
			}
			ids.push(selected[i]['id']);
		}

		return ids;
	},
	createAccess: function (btn, e) {
		var w = MODx.load({
			xtype: 'organizations-access-window-create',
			id: Ext.id(),
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		});
		w.reset();
		w.setValues({active: true});
		w.show(e.target);
	},
	updateAccess: function (btn, e, row) {
		if (typeof(row) != 'undefined') {
			this.menu.record = row.data;
		}
		else if (!this.menu.record) {
			return false;
		}
		var w = MODx.load({
			xtype: 'organizations-access-window-update',
			id: Ext.id(),
			//record: this.menu.record,
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		});
		w.reset();
		w.setValues(this.menu.record);
		w.show(e.target);
	},
	removeAccess: function (act, btn, e) {
		var ids = this._getSelectedIds();
		if (!ids.length) {
			return false;
		}
		MODx.msg.confirm({
			title: ids.length > 1
				? _('organizations_accesss_remove')
				: _('organizations_access_remove'),
			text: ids.length > 1
				? _('organizations_accesss_remove_confirm')
				: _('organizations_access_remove_confirm'),
			url: this.config.url,
			params: {
				action: 'mgr/settings/accessremove',
				ids: Ext.util.JSON.encode(ids),
			},
			listeners: {
				success: {
					fn: function (r) {
						this.refresh();
					}, scope: this
				}
			}
		});
		return true;
	},
});
Ext.reg('organizations-grid-access', Organizations.grid.Access);

Organizations.window.CreateAccess = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-access-window-create';
	}
	Ext.applyIf(config, {
		title: _('organizations_access_create'),
		width: 300,
		height: 300,
		url: Organizations.config.connector_url,
		action: 'mgr/settings/accesscreate',
		layout: 'anchor',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}],
	});
	Organizations.window.CreateAccess.superclass.constructor.call(this, config);
};

Ext.extend(Organizations.window.CreateAccess, MODx.Window, {
	getFields: function (config) {
		return [{
				xtype: 'textfield',
				fieldLabel: _('organizations_access_name'),
				name: 'name',
				id: config.id + '-' + 'name',
				anchor: '99%'
			},{
				xtype: 'textarea',
				fieldLabel: _('organizations_access_description'),
				name: 'label',
				id: config.id + '-' + 'label',
				anchor: '99%'
			}];
	},
});
Ext.reg('organizations-access-window-create', Organizations.window.CreateAccess);

Organizations.window.UpdateAccess = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-access-window-update';
	}
	Ext.applyIf(config, {
		title: _('organizations_access_update'),
		width: 300,
		height: 300,
		url: Organizations.config.connector_url,
		action: 'mgr/settings/accessupdate',
		layout: 'anchor',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}],
	});
	Organizations.window.UpdateAccess.superclass.constructor.call(this, config);
};

Ext.extend(Organizations.window.UpdateAccess, MODx.Window, {
	getFields: function (config) {
		return [{
				xtype: 'hidden',
				//fieldLabel: _('organizations_access_name'),
				name: 'id',
				id: config.id + '-' + 'id',
				anchor: '99%'
			},{
				xtype: 'textfield',
				fieldLabel: _('organizations_access_name'),
				name: 'name',
				id: config.id + '-' + 'name',
				anchor: '99%'
			},{
				xtype: 'textarea',
				fieldLabel: _('organizations_access_description'),
				name: 'label',
				id: config.id + '-' + 'label',
				anchor: '99%'
			}];
	},
});
Ext.reg('organizations-access-window-update', Organizations.window.UpdateAccess);