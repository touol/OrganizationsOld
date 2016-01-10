Organizations.grid.Fields = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-grid-fields';
	}
	this.dd = function(grid) {
		this.dropTarget = new Ext.dd.DropTarget(grid.container, {
			ddGroup : 'dd',
			copy:false,
			notifyDrop : function(dd, e, data) {
				var store = grid.store.data.items;
				var target = store[dd.getDragData(e).rowIndex].id;
				var source = store[data.rowIndex].id;
				if (target != source) {
					dd.el.mask(_('loading'),'x-mask-loading');
					MODx.Ajax.request({
						url: Organizations.config.connector_url
						,params: {
							action: config.action || 'mgr/settings/sort'
							,source: source
							,target: target
						}
						,listeners: {
							success: {fn:function(r) {dd.el.unmask();grid.refresh();},scope:grid}
							,failure: {fn:function(r) {dd.el.unmask();},scope:grid}
						}
					});
				}
			}
		});
	};
	Ext.applyIf(config, {
		url: Organizations.config.connector_url,
		fields: this.getFields(config),
		columns: this.getColumns(config),
		//tbar: this.getTopBar(config),
		sm: new Ext.grid.CheckboxSelectionModel(),
		baseParams: {
			action: 'mgr/settings/getlist',
			//settings: 'org_fields'
		},
		listeners: {render: {fn: this.dd, scope: this}},
		save_action: 'mgr/settings/update',
		autosave: true,
		enableDragDrop: true,
		ddGroup: 'dd',
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
	Organizations.grid.Fields.superclass.constructor.call(this, config);

	// Clear selection on grid refresh
	/* this.store.on('load', function () {
		if (this._getSelectedIds().length) {
			this.getSelectionModel().clearSelections();
		}
	}, this); */
};
Ext.extend(Organizations.grid.Fields, MODx.grid.Grid, {
	getFields: function (config) {
		return ['id', 'name', 'label', 'rank', 'xtype', 'column', 'active'];
	},
	getColumns: function (config) {
		return [{
			header: _('organizations_fields_id'),
			dataIndex: 'id',
			sortable: true,
			width: 70
		}, {
			header: _('organizations_fields_name'),
			dataIndex: 'name',
			sortable: true,
			width: 200,
			editor: {xtype: 'textfield'},
		}, {
			header: _('organizations_fields_label'),
			dataIndex: 'label',
			sortable: false,
			width: 100,
			editor: {xtype: 'textfield'},
		}, {
			header: _('organizations_fields_xtype'),
			dataIndex: 'xtype',
			sortable: false,
			width: 100,
			editor: {xtype: 'organizations-combo-units', renderer: true},
		}, {
			header: _('organizations_fields_column'),
			dataIndex: 'column',
			sortable: false,
			width: 100,
			editor: {xtype: 'organizations-combo-cols', renderer: true},
		}, {
			header: _('organizations_fields_rank'),
			dataIndex: 'rank',
			sortable: false,
			width: 50,
			editor: {xtype: 'textfield'},
		}, {
			header: _('organizations_item_active'),
			dataIndex: 'active',
			width: 50, 
			editor: {xtype: 'combo-boolean', renderer: 'boolean'}
		}];
	},
});
Ext.reg('organizations-grid-fields', Organizations.grid.Fields);

Organizations.combo.Units = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['unit','display']
            ,data: [
                ['textfield','textfield'],
				['textarea','textarea'],
				['xcheckbox','xcheckbox'],
				['org-combo-dadata','org-combo-dadata'],
				['bank-combo-dadata','bank-combo-dadata'],
				['fio-combo-dadata','fio-combo-dadata'],
				['addr-combo-dadata','addr-combo-dadata'],
				['email-combo-dadata','email-combo-dadata'],
				['manager-combo','manager-combo']
            ]
        })
        ,mode: 'local'
        ,displayField: 'display'
        ,valueField: 'unit'
    });
    Organizations.combo.Units.superclass.constructor.call(this,config);
};
Ext.extend(Organizations.combo.Units,MODx.combo.ComboBox);
Ext.reg('organizations-combo-units',Organizations.combo.Units);
Organizations.combo.Cols = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['unit','display']
            ,data: [
				['0','0'],
                ['1','1'],
				['2','2'],
				['3','3']
            ]
        })
        ,mode: 'local'
        ,displayField: 'display'
        ,valueField: 'unit'
    });
    Organizations.combo.Cols.superclass.constructor.call(this,config);
};
Ext.extend(Organizations.combo.Cols,MODx.combo.ComboBox);
Ext.reg('organizations-combo-cols',Organizations.combo.Cols);