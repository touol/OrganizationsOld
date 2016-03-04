Organizations.grid.Kupons = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-grid-kupons';
	}
	Ext.applyIf(config, {
		url: Organizations.config.connector_url,
		fields: this.getFields(config),
		columns: this.getColumns(config),
		tbar: this.getTopBar(config),
		sm: new Ext.grid.CheckboxSelectionModel(),
		baseParams: {
			action: 'mgr/kupons/getlist'
		},
		/* listeners: {
			rowDblClick: function (grid, rowIndex, e) {
				var row = grid.store.getAt(rowIndex);
				this.updateOrg(grid, e, row);
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
	Organizations.grid.Kupons.superclass.constructor.call(this, config);

	// Clear selection on grid refresh
	this.store.on('load', function () {
		if (this._getSelectedIds().length) {
			this.getSelectionModel().clearSelections();
		}
	}, this);
};
Ext.extend(Organizations.grid.Kupons, MODx.grid.Grid, {
	windows: {},

	getMenu: function (grid, rowIndex) {
		var ids = this._getSelectedIds();

		var row = grid.getStore().getAt(rowIndex);
		var menu = Organizations.utils.getMenu(row.data['actions'], this, ids);

		this.addContextMenuItem(menu);
	},

	createKupon: function (btn, e) {
		var w = MODx.load({
			xtype: 'organizations-kupons-window-create',
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
		w.setValues({use_count: 1, type: 1});
		w.show(e.target);
	},
	getFieldsShow: function (response) {
		
	},

	removeKupon: function (act, btn, e) {
		var ids = this._getSelectedIds();
		if (!ids.length) {
			return false;
		}
		MODx.msg.confirm({
			title: ids.length > 1
				? _('organizations_kupons_remove')
				: _('organizations_kupon_remove'),
			text: ids.length > 1
				? _('organizations_kupons_remove_confirm')
				: _('organizations_kupon_remove_confirm'),
			url: this.config.url,
			params: {
				action: 'mgr/kupons/remove',
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
		
		return ['id','kupon_code', 'type','description', 'org_id', 'shortname', 'user_id', 'username', 'createdby_user_id', 'createdby_user_name', 'createdon', 'date_exp', 'last_used_user_id', 'last_used_user_name', 'add_discount_proc', 'discount_price', 'use_count', 'used_count', 'used', 'actions'];
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
			header: _('organizations_grid_kupon_code'),
			dataIndex: 'kupon_code',
			sortable: true,
			width: 100,
		},{
			header: _('organizations_grid_username'),
			dataIndex: 'username',
			sortable: true,
			width: 100,
			renderer: Organizations.utils.userLink,
		},{
			header: _('organizations_grid_add_discount_proc'),
			dataIndex: 'add_discount_proc',
			sortable: true,
			width: 100,
		},{
			header: _('organizations_grid_discount_price'),
			dataIndex: 'discount_price',
			sortable: true,
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
			text: '<i class="icon icon-plus"></i>&nbsp;' + _('organizations_kupon_create'),
			handler: this.createKupon,
			scope: this
		}, '->', {
			xtype: 'textfield',
			name: 'query',
			width: 300,
			id: config.id + '-search-field',
			emptyText: _('organizations_grid_kupon_search'),
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
Ext.reg('organizations-grid-kupons', Organizations.grid.Kupons);

Organizations.window.createKupon = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-kupons-window-create';
	}
	Ext.applyIf(config, {
		title: _('organizations_kupons_create'),
		width: 500,
		height: 500,
		url: Organizations.config.connector_url,
		action: 'mgr/kupons/create',
		layout: 'anchor',
		/* return ['id','kupon_code', 'type','description', 'org_id', 'shortname', 'user_id', 'username', 'createdby_user_id', 'createdby_user_name', 'createdon', 'date_exp', 'last_used_user_id', 'last_used_user_name', 'add_discount_proc', 'discount_price', 'use_count', 'used_count', 'used', 'actions']; */
		
		fields: [{
				xtype: 'organizations-combo-kupons-type',
				fieldLabel: _('organizations_kupon_type'),
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
				xtype: 'organizations-combo-user',
				fieldLabel: _('organizations_grid_user_username'),
				//name: 'user_id',
				id: config.id + '-' + 'user_id',
				anchor: '99%',
				hidden: true,
			},{
				xtype: 'textfield',
				fieldLabel: _('organizations_kupon_add_discount_proc'),
				name: 'add_discount_proc',
				id: config.id + '-' + 'add_discount_proc',
				anchor: '99%',
				hidden: true,
			},{
				xtype: 'textfield',
				fieldLabel: _('organizations_kupon_discount_price'),
				name: 'discount_price',
				id: config.id + '-' + 'discount_price',
				anchor: '99%'
			},{
				xtype: 'textfield',
				fieldLabel: _('organizations_kupon_use_count'),
				name: 'use_count',
				id: config.id + '-' + 'use_count',
				anchor: '99%',
				hidden: true,
			},{
				xtype: 'textfield',
				fieldLabel: _('organizations_kupon_period'),
				name: 'period',
				id: config.id + '-' + 'period',
				anchor: '99%',
				hidden: true,
			},{
				xtype: 'hidden',
				name: 'invate_window',
				id: config.id + '-' + 'invate_window',
				anchor: '99%',
			}],
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}]
	});
	Organizations.window.createKupon.superclass.constructor.call(this, config);
	this.on('success',this.onCreate,this);
};
Ext.extend(Organizations.window.createKupon, MODx.Window, {
	onCreate: function(o) {
        var r = o.a.result;
		if(r.object.id && r.object.kupon_code && r.object.invate_window){
			invite = Ext.getCmp(r.object.invate_window);
			invite.setValues({kupon_id: r.object.id, kupon_code: r.object.kupon_code});
		}

    }
});
Ext.reg('organizations-kupons-window-create', Organizations.window.createKupon);

Organizations.combo.KuponsType = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['type','display']
            ,data: [
                [1,'KuponOrgPrice'],
				[2,'KuponOrgProcent'],
				[3,'KuponUser'],
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
					switch(value.id){
						case 1:
							Ext.getCmp(id + 'add_discount_proc').hide();
							Ext.getCmp(id + 'use_count').hide();
							Ext.getCmp(id + 'period').hide();
							Ext.getCmp(id + 'discount_price').show();
							Ext.getCmp(id + 'user_id').hide();
						break;
						case 2:
							Ext.getCmp(id + 'add_discount_proc').show();
							Ext.getCmp(id + 'use_count').show();
							Ext.getCmp(id + 'period').show();
							Ext.getCmp(id + 'discount_price').hide();
							Ext.getCmp(id + 'user_id').hide();
						break;
						case 3:
							Ext.getCmp(id + 'user_id').show();
							Ext.getCmp(id + 'add_discount_proc').show();
							Ext.getCmp(id + 'use_count').show();
							Ext.getCmp(id + 'period').show();
							Ext.getCmp(id + 'org_id').show();
							Ext.getCmp(id + 'discount_price').show();
						break;
					}
					return true;
                }
            }
        }
    });
    Organizations.combo.KuponsType.superclass.constructor.call(this,config);
};
Ext.extend(Organizations.combo.KuponsType,MODx.combo.ComboBox);
Ext.reg('organizations-combo-kupons-type',Organizations.combo.KuponsType);