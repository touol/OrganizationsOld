
Organizations.grid.Orgs = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-grid-orgs';
	}
	Ext.Ajax.request({
			url: Organizations.config.connector_url,
			params: {
				action: 'mgr/orgs/getfields'
			},
			success:function(response){
				//console.info(response.responseText);
				Organizations.config.org_fields = JSON.parse(response.responseText);
				//console.info(Organizations.config);
			}
	});
	Ext.applyIf(config, {
		url: Organizations.config.connector_url,
		fields: this.getFields(config),
		columns: this.getColumns(config),
		tbar: this.getTopBar(config),
		sm: new Ext.grid.CheckboxSelectionModel(),
		baseParams: {
			action: 'mgr/orgs/getlist'
		},
		listeners: {
			rowDblClick: function (grid, rowIndex, e) {
				var row = grid.store.getAt(rowIndex);
				this.updateOrg(grid, e, row);
			}
		},
		viewConfig: {
			forceFit: true,
			enableRowBody: true,
			autoFill: true,
			showPreview: true,
			scrollOffset: 0,
			getRowClass: function (rec, ri, p) {
				return !rec.data.active
					? 'organizations-grid-row-disabled'
					: '';
			}
		},
		paging: true,
		remoteSort: true,
		autoHeight: true,
	});
	Organizations.grid.Orgs.superclass.constructor.call(this, config);

	// Clear selection on grid refresh
	this.store.on('load', function () {
		if (this._getSelectedIds().length) {
			this.getSelectionModel().clearSelections();
		}
	}, this);
	var params = Ext.urlDecode(location.search.substring(1));
	if (typeof params.id !== 'undefined') {
		var org_id = Ext.getCmp(this.config.id + '-search-field-org_id');
		if(org_id) org_id.setValue(params.id);
		this._doSearch();
	}
	
};
Ext.extend(Organizations.grid.Orgs, MODx.grid.Grid, {
	windows: {},

	getMenu: function (grid, rowIndex) {
		var ids = this._getSelectedIds();

		var row = grid.getStore().getAt(rowIndex);
		var menu = Organizations.utils.getMenu(row.data['actions'], this, ids);

		this.addContextMenuItem(menu);
	},

	createOrg: function (btn, e) {
		var w = MODx.load({
			xtype: 'organizations-orgs-window-create',
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
	addInvite: function (btn, e) {
		if (typeof(row) != 'undefined') {
			this.menu.record = row.data;
		}
		else if (!this.menu.record) {
			return false;
		}
		var id = this.menu.record.id;
		
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
		w.setValues({org_id: id, send_email: true, user_group_id: 1, type: 1 });
		w.show(e.target);
	},
	
	addKupon: function (btn, e) {
		if (typeof(row) != 'undefined') {
			this.menu.record = row.data;
		}
		else if (!this.menu.record) {
			return false;
		}
		var id = this.menu.record.id;
		
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
		w.setValues({org_id: id, use_count: 1, type: 1});
		w.show(e.target);
	},
	
	getFieldsShow: function (response) {
		
	},
	updateOrg: function (btn, e, row) {
		if (typeof(row) != 'undefined') {
			this.menu.record = row.data;
		}
		else if (!this.menu.record) {
			return false;
		}
		var id = this.menu.record.id;

		MODx.Ajax.request({
			url: this.config.url,
			params: {
				action: 'mgr/orgs/get',
				id: id
			},
			listeners: {
				success: {
					fn: function (r) {
						var w = MODx.load({
							xtype: 'organizations-orgs-window-update',
							id: Ext.id(),
							record: r,
							listeners: {
								success: {
									fn: function () {
										this.refresh();
									}, scope: this
								}
							}
						});
						w.reset();
						w.setValues(r.object);
						w.show(e.target);
					}, scope: this
				}
			}
		});
	},
	updateUsers: function (btn, e, row) {
		if (typeof(row) != 'undefined') {
			this.menu.record = row.data;
		}
		else if (!this.menu.record) {
			return false;
		}
		var id = this.menu.record.id;
		MODx.Ajax.request({
			url: this.config.url,
			params: {
				action: 'mgr/orgs/get',
				id: id
			},
			listeners: {
				success: {
					fn: function (r) {
						var w = MODx.load({
							xtype: 'organizations-users-window',
							id: Ext.id(),
							record: r,
							listeners: {
								success: {
									fn: function () {
										this.refresh();
									}, scope: this
								}
							}
						});
						w.reset();
						w.setValues(r.object);
						w.show(e.target);
					}, scope: this
				}
			}
		});
	},

	removeOrg: function (act, btn, e) {
		var ids = this._getSelectedIds();
		if (!ids.length) {
			return false;
		}
		MODx.msg.confirm({
			title: ids.length > 1
				? _('organizations_orgs_remove')
				: _('organizations_org_remove'),
			text: ids.length > 1
				? _('organizations_orgs_remove_confirm')
				: _('organizations_org_remove_confirm'),
			url: this.config.url,
			params: {
				action: 'mgr/orgs/remove',
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

	disableOrg: function (act, btn, e) {
		var ids = this._getSelectedIds();
		if (!ids.length) {
			return false;
		}
		MODx.Ajax.request({
			url: this.config.url,
			params: {
				action: 'mgr/orgs/disable',
				ids: Ext.util.JSON.encode(ids),
			},
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		})
	},

	enableOrg: function (act, btn, e) {
		var ids = this._getSelectedIds();
		if (!ids.length) {
			return false;
		}
		MODx.Ajax.request({
			url: this.config.url,
			params: {
				action: 'mgr/orgs/enable',
				ids: Ext.util.JSON.encode(ids),
			},
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		})
	},

	getFields: function (config) {
		
		return ['id','urlico','shortname','longtname','inn','kpp','kontragent','discount','manager_id','manager','active', 'actions'];
	},

	getColumns: function (config) {
		
		return [ {
			header: _('organizations_grid_id'),
			dataIndex: 'id',
			sortable: false,
			width: 50,
		},{
			header: _('organizations_lico'),
			dataIndex: 'urlico',
			renderer: Organizations.utils.renderBooleanLico,
			sortable: true,
			width: 70,
		},{
			header: _('organizations_grid_shortname'),
			dataIndex: 'shortname',
			sortable: true,
			width: 100,
		},{
			header: _('organizations_grid_inn'),
			dataIndex: 'inn',
			sortable: true,
			width: 100,
		},{
			header: _('organizations_grid_kpp'),
			dataIndex: 'kpp',
			sortable: true,
			width: 100,
		},{
			header: _('organizations_grid_user_discount'),
			dataIndex: 'discount',
			sortable: true,
			width: 100,
		},{
			header: _('organizations_grid_manager'),
			dataIndex: 'manager',
			sortable: true,
			width: 100,
			renderer: Organizations.utils.managerLink,
		},{
			header: _('organizations_item_active'),
			dataIndex: 'active',
			renderer: Organizations.utils.renderBoolean,
			sortable: true,
			width: 70,
		},{
			header: _('organizations_grid_actions'),
			dataIndex: 'actions',
			renderer: Organizations.utils.renderActions,
			sortable: false,
			width: 180,
			id: 'actions'
		}];
	},

	getTopBar: function (config) {
		return [{
			text: '<i class="icon icon-plus"></i>&nbsp;' + _('organizations_org_create'),
			handler: this.createOrg,
			scope: this
		},{
            text: _('organizations_org_clean'),
            handler: this.cleanOrg,
            scope: this
        },{
			text: _('organizations_org_export'),
            handler: this._exportExcel,
            scope: this
		}, '->', {
			xtype: 'textfield',
			name: 'query',
			width: 100,
			id: config.id + '-search-field-org_id',
			emptyText: _('organizations_grid_org_id_search'),
			listeners: {
				render: {
					fn: function (tf) {
						tf.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
							this._doSearch();
						}, this);
					}, scope: this
				}
			}
		}, {
			xtype: 'textfield',
			name: 'query',
			width: 300,
			id: config.id + '-search-field',
			emptyText: _('organizations_grid_org_search'),
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
	
	_exportExcel: function (tf) {
		query = Ext.getCmp(this.config.id + '-search-field').getValue();
		url ='/assets/components/organizations/export_org.php?query=' + query;
		window.open(url, '_blank');
	},
	
	cleanOrg: function (btn, e) {
		var w = MODx.load({
            xtype: 'organizations-window-cleanorg',
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
        w.setValues({url_scheme:"http"});
        w.show(e.target);
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
		if(tf){
			this.getStore().baseParams.query = tf.getValue();
		}
		var org_id = Ext.getCmp(this.config.id + '-search-field-org_id');
		if(org_id) this.getStore().baseParams.org_id = org_id.getValue();
		
		this.getBottomToolbar().changePage(1);
		this.refresh();
	},

	_clearSearch: function (btn, e) {
		this.getStore().baseParams.query = '';
		Ext.getCmp(this.config.id + '-search-field').setValue('');
		
		this.getStore().baseParams.org_id = '';
		var org_id = Ext.getCmp(this.config.id + '-search-field-org_id');
		if(org_id) org_id.setValue('');
		
		this.getBottomToolbar().changePage(1);
		this.refresh();
	}
});
Ext.reg('organizations-grid-orgs', Organizations.grid.Orgs);

Organizations.window.CleanOrg = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'organizations-window-cleanorg';
    }
    Ext.applyIf(config, {
        title: _('organizations_org_clean'),
        width: 550,
        autoHeight: true,
        url: Organizations.config.connector_url,
        fields: this.getFields(config),
		buttons: [{
            text: config.cancelBtnText || _('cancel')
            ,scope: this
            ,handler: function() { this.hide(); }
        },{
            text: _('organizations_org_clean')
            ,cls: 'primary-button'
            ,scope: this
            ,handler: function() { this.cleanOrg();}
        }]
    });
    Organizations.window.CleanOrg.superclass.constructor.call(this, config);
};
Ext.extend(Organizations.window.CleanOrg, MODx.Window, {

    getFields: function (config) {
        return [{
			xtype: 'xcheckbox',
            boxLabel: _('organizations_cleanorg_remove_users'),
            name: 'remove_users',
            id: config.id + '-remove_users',
            checked: false,
		}, {
			xtype: 'modx-combo-browser',
			fieldLabel: _('organizations_cleanorg_excel_file'),
			name: 'excel_file',
			id: config.id + '-excel_file',
			hideFiles: true,
			source: MODx.config.default_media_source,
			hideSourceCombo: true,
			anchor: '99%'
        }];
    },
	
	cleanOrg: function () {
		var topic = '/organizations/';
		var register = 'mgr';
		this.console = MODx.load({
		   xtype: 'modx-console'
		   ,register: register
		   ,topic: topic
		   ,show_filename: 0
		   ,listeners: {
			 'shutdown': {fn:function() {
				 Ext.getCmp('organizations-grid-orgs').refresh();
			 },scope:this}
		   }
		});
		this.console.show(Ext.getBody());
		
		var excel_file = Ext.getCmp(this.config.id + '-excel_file').getValue();
		var remove_users = Ext.getCmp(this.config.id + '-remove_users').getValue();
		MODx.Ajax.request({
			url: this.config.url
			,params: {
				action: 'mgr/orgs/cleanorg'
				,register: register
				,topic: topic
				,excel_file: excel_file
				,remove_users: remove_users
			}
			,listeners: {
				'success':{fn:function() {
					this.console.fireEvent('complete');
				},scope:this}
			}
		});
		this.hide();
    },
	
    loadDropZones: function () {
    }

});
Ext.reg('organizations-window-cleanorg', Organizations.window.CleanOrg);
