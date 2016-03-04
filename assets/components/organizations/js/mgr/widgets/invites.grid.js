Organizations.grid.Invites = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-grid-invites';
	}
	Ext.applyIf(config, {
		url: Organizations.config.connector_url,
		fields: this.getFields(config),
		columns: this.getColumns(config),
		tbar: this.getTopBar(config),
		sm: new Ext.grid.CheckboxSelectionModel(),
		baseParams: {
			action: 'mgr/invites/getlist'
		},
		/* listeners: {
			rowDblClick: function (grid, rowIndex, e) {
				var row = grid.store.getAt(rowIndex);
				this.updateInvite(grid, e, row);
			}
		}, */
		viewConfig: {
			forceFit: true,
			enableRowBody: true,
			autoFill: true,
			showPreview: true,
			scrollOffset: 0,
			getRowClass: function (rec, ri, p) {
				return rec.data.used
					? 'organizations-grid-row-disabled'
					: '';
			}
		},
		paging: true,
		remoteSort: true,
		autoHeight: true,
	});
	Organizations.grid.Invites.superclass.constructor.call(this, config);

	// Clear selection on grid refresh
	this.store.on('load', function () {
		if (this._getSelectedIds().length) {
			this.getSelectionModel().clearSelections();
		}
	}, this);
};
Ext.extend(Organizations.grid.Invites, MODx.grid.Grid, {
	windows: {},

	getMenu: function (grid, rowIndex) {
		var ids = this._getSelectedIds();

		var row = grid.getStore().getAt(rowIndex);
		var menu = Organizations.utils.getMenu(row.data['actions'], this, ids);

		this.addContextMenuItem(menu);
	},

	createInvite: function (btn, e) {
		var w = MODx.load({
			xtype: 'organizations-invites-window-create',
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
		w.setValues({send_email: true, user_group_id: 1, type: 1 });
		w.show(e.target);
	},
	getFieldsShow: function (response) {
		
	},

	sendInvite: function (act, btn, e) {
		var ids = this._getSelectedIds();
		if (!ids.length) {
			return false;
		}
		MODx.msg.confirm({
			title: ids.length > 1
				? _('organizations_invites_send')
				: _('organizations_invite_send'),
			text: ids.length > 1
				? _('organizations_invites_send_confirm')
				: _('organizations_invite_send_confirm'),
			url: this.config.url,
			params: {
				action: 'mgr/invites/send',
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
	
	removeInvite: function (act, btn, e) {
		var ids = this._getSelectedIds();
		if (!ids.length) {
			return false;
		}
		MODx.msg.confirm({
			title: ids.length > 1
				? _('organizations_invites_remove')
				: _('organizations_invite_remove'),
			text: ids.length > 1
				? _('organizations_invites_remove_confirm')
				: _('organizations_invite_remove_confirm'),
			url: this.config.url,
			params: {
				action: 'mgr/invites/remove',
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
		
		return ['id','invite_code', 'type','description', 'org_id', 'shortname', 'user_group_id', 'user_group_name','email','email_sended','fullname','kupon_id','kupon_code','createdby_user_id', 'createdby_user_name', 'createdon', 'date_exp', 'used_user_id', 'used_user_name', 'used', 'actions'];
	},

	getColumns: function (config) {
		
		return [ {
			header: _('organizations_grid_id'),
			dataIndex: 'id',
			sortable: false,
			width: 50,
		},{
			header: _('organizations_grid_shortname'),
			dataIndex: 'shortname',
			sortable: true,
			width: 100,
		},{
			header: _('organizations_grid_invite_code'),
			dataIndex: 'invite_code',
			sortable: true,
			width: 100,
		},{
			header: _('organizations_grid_fullname'),
			dataIndex: 'fullname',
			sortable: true,
			width: 100,
		},{
			header: _('organizations_grid_email_sended'),
			dataIndex: 'email_sended',
			sortable: true,
			renderer: Organizations.utils.renderBoolean,
			width: 100,
		},{
			header: _('organizations_grid_createdby_user_name'),
			dataIndex: 'createdby_user_name',
			sortable: true,
			width: 100,
			renderer: Organizations.utils.createuserLink,
		},{
			header: _('organizations_grid_createdon'),
			dataIndex: 'createdon',
			sortable: true,
			width: 100,
		},{
			header: _('organizations_grid_used'),
			dataIndex: 'used',
			renderer: Organizations.utils.renderBoolean,
			sortable: true,
			width: 100,
		},{
			header: _('organizations_grid_date_exp'),
			dataIndex: 'date_exp',
			sortable: true,
			width: 100,
		},{
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
			text: '<i class="icon icon-plus"></i>&nbsp;' + _('organizations_invite_create'),
			handler: this.createInvite,
			scope: this
		}, '->', {
			xtype: 'textfield',
			name: 'query',
			width: 300,
			id: config.id + '-search-field',
			emptyText: _('organizations_grid_invite_search'),
			listeners: {
				render: {
					fn: function (tf) {
						tf.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
							this._doSearch(tf);
						}, this);
					}, scope: this
				}
			}
		}, {
			xtype: 'button',
			id: config.id + '-search-clear',
			text: '<i class="icon icon-times"></i>',
			listeners: {
				click: {fn: this._clearSearch, scope: this}
			}
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

	_doSearch: function (tf, nv, ov) {
		this.getStore().baseParams.query = tf.getValue();
		this.getBottomToolbar().changePage(1);
		this.refresh();
	},

	_clearSearch: function (btn, e) {
		this.getStore().baseParams.query = '';
		Ext.getCmp(this.config.id + '-search-field').setValue('');
		this.getBottomToolbar().changePage(1);
		this.refresh();
	}
});
Ext.reg('organizations-grid-invites', Organizations.grid.Invites);

Organizations.window.createInvite = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-invites-window-create';
	}
	Ext.applyIf(config, {
		title: _('organizations_invites_create'),
		width: 500,
		height: 500,
		url: Organizations.config.connector_url,
		action: 'mgr/invites/create',
		layout: 'anchor',
		
		fields: [{
				xtype: 'organizations-combo-invites-type',
				fieldLabel: _('organizations_invite_type'),
				//name: 'type',
				id: config.id + '-' + 'type',
				anchor: '99%' 
			},{
				xtype: 'org-combo',
				fieldLabel: _('organizations_org'),
				//name: 'org_id',
				id: config.id + '-' + 'org_id',
				anchor: '99%'
			},{
				xtype: 'textfield',
				fieldLabel: _('organizations_grid_fullname'),
				name: 'fullname',
				id: config.id + '-' + 'fullname',
				anchor: '99%'
			},{
				xtype: 'textfield',
				fieldLabel: _('organizations_invite_email'),
				name: 'email',
				id: config.id + '-' + 'email',
				anchor: '99%'
			},{
				xtype: 'xcheckbox',
				fieldLabel: _('organizations_user_send_email'),
				name: 'send_email',
				id: config.id + '-' + 'send_email',
				anchor: '99%'				
			},{
				xtype: 'textfield',
				fieldLabel: _('organizations_invite_period'),
				name: 'period',
				id: config.id + '-' + 'period',
				anchor: '99%',
				hidden: true,
			},{
				xtype: 'button',
				id: config.id + '-greate-kupon',
				text:  _('organizations_kupon_create'),
				listeners: {
					click: {fn: this._createKupon, scope: this}
				},
				hidden: true,
				anchor: '99%'
			},{
				xtype: 'hidden',
				name: 'kupon_id',
				id: config.id + '-' + 'kupon_code',
				anchor: '99%',
			},{
				xtype: 'textfield',
				fieldLabel: _('organizations_grid_kupon_code'),
				name: 'kupon_code',
				id: config.id + '-' + 'kupon_code',
				anchor: '99%',
				hidden: true
			},{
				xtype: 'group-combo',
				fieldLabel: _('organizations_user_group_name'),
				//name: 'user_group_id',
				id: config.id + '-' + 'user_group_id',
				anchor: '99%',
				hidden: true
			}],
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}]
	});
	Organizations.window.createInvite.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.window.createInvite, MODx.Window, {
	_createKupon: function (btn, e) {
		var f = this.fp.getForm();
		r=f.getValues();
		var w = MODx.load({
			xtype: 'organizations-kupons-window-create',
			id: Ext.id(),
			listeners: {
				success: {
					fn: function () {
						//this.refresh();
					}, scope: this
				}
			}
		});
		w.reset();
		w.setValues({org_id: r.org_id, use_count: 1, type: 1, invate_window: this.config.id});
		w.show(e.target);
	},
});
Ext.reg('organizations-invites-window-create', Organizations.window.createInvite);

Organizations.combo.InvitesType = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['type','display']
            ,data: [
                [1,'InviteOrg1'],
				[2,'InviteOrg2'],
				[3,'InviteUser1'],
            ]
        })
        ,mode: 'local'
        ,displayField: 'display'
        ,valueField: 'type'
		,hiddenName:'type'
		,listeners: {
            select: {
                fn: function (combo, value) {
					id = combo.id.substr(0, combo.id.length - combo.hiddenName.length);
					if(value.id==2){
						Ext.getCmp(id + 'greate-kupon').show();
						Ext.getCmp(id + 'user_group_id').show();
						Ext.getCmp(id + 'kupon_code').show();
						Ext.getCmp(id + 'period').show();
					}
					return true;
                }
            }
        }
    });
    Organizations.combo.InvitesType.superclass.constructor.call(this,config);
};
Ext.extend(Organizations.combo.InvitesType,MODx.combo.ComboBox);
Ext.reg('organizations-combo-invites-type',Organizations.combo.InvitesType);