Ext.define('Webit.grid.editable.EditWindow',{
	extend: 'Ext.window.Window',
	alias: 'widget.webit_grid_editable_edit_window',
	modal: true,
	closable: true,
	resizable: false,
	defaults: {
		frame: true,
		border: false
	},
	listeners: {
		maximize: function(win) {
			win.center();
		},
		restore: function(win) {
			win.doLayout();
		}
	},
	grid: null,
	model: null,
	bbar: ['->',{
		text: 'Zapisz',
		itemId: 'save',
		iconCls: 'fam-silk-tick'
	},{
		text: 'Anuluj',
		itemId: 'cancel',
		iconCls: 'fam-silk-cross',
		handler: function(btn) {
			btn.up('window').close();
		}
	}],
	initComponent: function() {
		this.addEvents('recordLoad','beforeRecordSave');
		if(this.grid && Ext.isEmpty(this.renderTo)) {
			Ext.apply(this,{
				renderTo: this.grid.getEl()
			});
		}

		this.callParent();
	},
	getModel: function() {
		return Ext.ModelManager.getModel(this.model || this.grid.getStore().model);
	},
	updateRecord: function(r, form) {
		var obj = this.getValuesObject(r, form);
		this.applyValuesToRecord(r, obj);
	},
	// @private,
	getValuesObject: function (record, form) {
		var fields = record.fields.items,
			values = form.getFieldValues(),
			obj = {},
			i = 0,
			len = fields.length,
			name;

		for (; i < len; ++i) {
			name  = fields[i].name;

			if (values.hasOwnProperty(name)) {
				obj[name] = values[name];
			}
		}

		return obj;
	},
	// @private
	applyValuesToRecord: function(r, values) {
		r.beginEdit();
		r.set(values);
		r.endEdit();
	}
});
