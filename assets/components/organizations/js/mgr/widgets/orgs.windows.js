Organizations.window.CreateOrg = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'organizations-orgs-window-create';
	}
	Ext.applyIf(config, {
		title: _('organizations_orgs_create'),
		width: 900,
		height: 500,
		url: Organizations.config.connector_url,
		action: 'mgr/orgs/create',
		layout: 'anchor',
		fields: this.getFields(config),
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
		var fields = []; var col1 = [];var col2 = [];var col3 = [];var field0 = [];
		org_fields = Organizations.config.org_fields;
		for (var z in org_fields){
			var field = {};
			if(org_fields[z]['active']){
				field.xtype =org_fields[z]['xtype'];
				field.fieldLabel = org_fields[z]['label'];
				field.name = org_fields[z]['name'];
				field.id = config.id + '-' + org_fields[z]['name'];
				field.anchor = '99%';
				if(field.name == 'shortname'){
					field.allowBlank = false;
				}
			}
			switch (org_fields[z]['column']){
				case '0':
					field0.push(field);
				break
				case '1':
					col1.push(field);
				break
				case '2':
					col2.push(field);
				break
				case '3':
					col3.push(field);
				break
			}
			
		}
		var cols1 = {};var cols2 = {};var cols3 = {};
		var cols11 = {};var cols21 = {};var cols31 = {};
		cols1.items = [];cols2.items = [];cols3.items = [];
		
		cols1.columnWidth = .33;
		cols11.layout = 'form';
		cols11.items = col1;
		cols1.items.push(cols11);
		cols2.columnWidth = .33;
		cols21.layout = 'form';
		cols21.items = col2;
		cols2.items.push(cols21);
		cols3.columnWidth = .33;
		cols31.layout = 'form';
		cols31.items = col3;
		cols3.items.push(cols31);
		fields.push(cols1,cols2,cols3);
		return [field0,{
			layout: 'column',
			defaults: {
				xtype: 'panel',
				columnWidth:0.33,
				labelAlign: 'top',
				anchor: '99%'
			},
			items:fields,
			renderTo: Ext.getBody()
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
		width: 990,
		height: 500,
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
		var fields = []; var col1 = [];var col2 = [];var col3 = [];var field0 = [];var org_fields = [];
		org_fields = Organizations.config.org_fields;
		for (var z in org_fields) {
			var field = {};
			if(org_fields[z]['active']){
				field.xtype =org_fields[z]['xtype'];
				field.fieldLabel = org_fields[z]['label'];
				field.name = org_fields[z]['name'];
				field.id = config.id + '-' + org_fields[z]['name'];
				field.anchor = '99%';
				if(field.name == 'shortname'){
					field.allowBlank = false;
				}
			}
			switch (org_fields[z]['column']){
				case '0':
					field0.push(field);
				break
				case '1':
					col1.push(field);
				break
				case '2':
					col2.push(field);
				break
				case '3':
					col3.push(field);
				break
			}
			
		}
		var cols1 = {};var cols2 = {};var cols3 = {};
		var cols11 = {};var cols21 = {};var cols31 = {};
		cols1.items = [];cols2.items = [];cols3.items = [];
		
		cols1.columnWidth = .33;
		cols11.layout = 'form';
		cols11.items = col1;
		cols1.items.push(cols11);
		cols2.columnWidth = .33;
		cols21.layout = 'form';
		cols21.items = col2;
		cols2.items.push(cols21);
		cols3.columnWidth = .33;
		cols31.layout = 'form';
		cols31.items = col3;
		cols3.items.push(cols31);
		fields.push(cols1,cols2,cols3);
		return [{
			xtype: 'hidden',
			name: 'id',
			id: config.id + '-id',
		},
		field0,
		{
			layout: 'column',
			defaults: {
				xtype: 'panel',
				columnWidth:0.33,
				labelAlign: 'top',
				anchor: '99%'
			},
			items:fields,
			renderTo: Ext.getBody()
			}];
	},

	loadDropZones: function() {
	}

});
Ext.reg('organizations-orgs-window-update', Organizations.window.UpdateOrg);

Ext.override(Ext.form.ComboBox, {
	onLoad : function(){
        if(!this.hasFocus){
            return;
        }
        if(this.store.getCount() > 0 || this.listEmptyText){
            this.expand();
            this.restrictHeight();
            if(this.lastQuery == this.allQuery){
                if(this.editable){
                    this.el.dom.select();
                }

                if(this.autoSelect !== false && !this.selectByValue(this.value, true)){
                    this.select(0, true);
                }
            }else{
                if(this.autoSelect !== false){
                    this.selectNext();
                }
                if(this.typeAhead && this.lastKey != Ext.EventObject.BACKSPACE && this.lastKey != Ext.EventObject.DELETE){
                    //this.taTask.delay(this.typeAheadDelay);
                }
            }
        }else{
            this.collapse();
        }

    },
	onSelect : function(record, index){
        if(this.fireEvent('beforeselect', this, record, index) !== false){
            this.collapse();
            if(this.fireEvent('select', this, record, index)!== false){
				this.setValue(record.data[this.valueField || this.displayField]);
			}
        }
    }
});
Organizations.combo.Dadata = function(config) {
    config = config || {};
    Ext.applyIf(config,{
	    minChars: 2,
	    hideTrigger: true,
		triggerAction: 'all',
	    emptyText: '',
		typeAhead: true,
	    //pageSize: true, // указание на то что нужно вывести листалку
		fields: ['value','search_value'],
		name: 'query',
		displayField: 'search_value',
		url: Organizations.config.connector_url,
		baseParams: config.baseParams || {},
		editable: true,
        autoSelect : false,
	});
	Ext.applyIf(config,{
        store: new Ext.data.JsonStore({
            url: config.connector || config.url
            ,root: 'results'
            ,totalProperty: 'total'
            ,fields: config.fields
            ,errorReader: MODx.util.JSONReader
            ,baseParams: config.baseParams || {}
            ,remoteSort: config.remoteSort || false
            ,autoDestroy: true
            ,listeners: {
                'loadexception': {fn: function(o,trans,resp) {
                    var status = _('code') + ': ' + resp.status + ' test ' + resp.statusText + '<br/>';
                    MODx.msg.alert(_('error'), status + resp.responseText);
                }}
            }
        }),
    });
    Organizations.combo.Dadata.superclass.constructor.call(this,config);
};
Ext.extend(Organizations.combo.Dadata,Ext.form.ComboBox);
Ext.reg('combo-dadata',Organizations.combo.Dadata);

Organizations.combo.DadataOrg = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		baseParams:{
            action: 'mgr/orgs/getdadata',
			suggest: 'party'
        },
		listeners: {
            select: {
                fn: function (combo, value) {
					combo.setValue(value.data.value);
					id = combo.id.substr(0, combo.id.length - combo.name.length);
					cmp = Ext.getCmp(id + 'longname');
					if(cmp !== undefined){cmp.setValue(value.json.data.name.full_with_opf);}
					cmp = Ext.getCmp(id + 'inn');
					if(cmp !== undefined){cmp.setValue(value.json.data.inn);}
					cmp = Ext.getCmp(id + 'kpp');
					if(cmp !== undefined){cmp.setValue(value.json.data.kpp);}
					cmp = Ext.getCmp(id + 'ogrn');
					if(cmp !== undefined){cmp.setValue(value.json.data.ogrn);}
					cmp = Ext.getCmp(id + 'okpo');
					if(cmp !== undefined){cmp.setValue(value.json.data.okpo);}
					cmp = Ext.getCmp(id + 'director');
					if(cmp !== undefined){cmp.setValue(value.json.data.management.name);}
					cmp = Ext.getCmp(id + 'ur_address');
					if(cmp !== undefined){cmp.setValue(value.json.data.address.value);}
					cmp = Ext.getCmp(id + 'postal_address');
					if(cmp !== undefined){cmp.setValue(value.json.data.address.value);}
					return false;
                }
            }
        }
    });
    Organizations.combo.DadataOrg.superclass.constructor.call(this,config);
};
Ext.extend(Organizations.combo.DadataOrg,Organizations.combo.Dadata);
Ext.reg('org-combo-dadata',Organizations.combo.DadataOrg);

Organizations.combo.DadataBank = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		baseParams:{
            action: 'mgr/orgs/getdadata',
			suggest: 'bank'
        },
		fields: ['value'],
		displayField: 'value',
		listeners: {
            select: {
                fn: function (combo, value) {
					id = combo.id.substr(0, combo.id.length - combo.name.length);
					cmp = Ext.getCmp(id + 'bank_bik');
					if(cmp !== undefined){cmp.setValue(value.json.data.bic);}
					cmp = Ext.getCmp(id + 'bank_kor_acc');
					if(cmp !== undefined){cmp.setValue(value.json.data.correspondent_account);}
                }
            }
        }
    });
    Organizations.combo.DadataBank.superclass.constructor.call(this,config);
};
Ext.extend(Organizations.combo.DadataBank,Organizations.combo.Dadata);
Ext.reg('bank-combo-dadata',Organizations.combo.DadataBank);

Organizations.combo.DadataFIO = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		baseParams:{
            action: 'mgr/orgs/getdadata',
			suggest: 'fio'
        },
		fields: ['value'],
		displayField: 'value',
    });
    Organizations.combo.DadataFIO.superclass.constructor.call(this,config);
};
Ext.extend(Organizations.combo.DadataFIO,Organizations.combo.Dadata);
Ext.reg('fio-combo-dadata',Organizations.combo.DadataFIO);

Organizations.combo.DadataAddr = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		baseParams:{
            action: 'mgr/orgs/getdadata',
			suggest: 'address'
        },
		fields: ['value'],
		displayField: 'value',
    });
    Organizations.combo.DadataAddr.superclass.constructor.call(this,config);
};
Ext.extend(Organizations.combo.DadataAddr,Organizations.combo.Dadata);
Ext.reg('addr-combo-dadata',Organizations.combo.DadataAddr);

Organizations.combo.DadataEmail = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		baseParams:{
            action: 'mgr/orgs/getdadata',
			suggest: 'email'
        },
		fields: ['value'],
		displayField: 'value',
    });
    Organizations.combo.DadataEmail.superclass.constructor.call(this,config);
};
Ext.extend(Organizations.combo.DadataEmail,Organizations.combo.Dadata);
Ext.reg('email-combo-dadata',Organizations.combo.DadataEmail);