Ext.define('Webit.view.grid.EditableGrid',{
	extend: 'Ext.grid.Panel',
	alias: 'widget.webit_grid_editablegrid',
	/**
	 * 
	 * @type String
	 * window or row
	 */
	editmode: 'window',
	editWindowConfig: null,
	newWindowConfig: null,
	rowEditing: {
  	clicksToMoveEditor: 2,
  	pluginId: 'rowEditing',
  	errorSummary: false,
  	autoCancel: true,
  	saveBtnText: 'Zapisz',
  	cancelBtnText: 'Anuluj'
	},
	buttonsVisibility: {
		refresh: false
	},
	dockedItems: [{
		xtype: 'toolbar',
		dock: 'right',
		itemId: 'edit',
		items: [{
			itemId: 'add',
			iconCls: 'fam-silk-add',
			tooltip: 'Dodaj'
		},{
			iconCls: 'fam-silk-pencil',
			itemId: 'edit',
			tooltip: 'Edytuj',
			disabled: true
		},{
			xtype: 'webit_button_deletebutton',
			disabled: true
		},{
			iconCls: 'fam-silk-arrow_refresh',
			itemId: 'refresh',
			tooltip: 'Odśwież',
			hidden: true
		}]
	}],
	getModelDefaults: function() {
		return {};
	},
	getEditWindowConfig: function() {
		return this.editWindowConfig;
	},
	getNewWindowConfig: function() {
		if(this.newWindowConfig) {
			return this.newWindowConfig;
		}
		
		return this.getEditWindowConfig();
	},
	initComponent: function() {
		this.addEvents('recordSave');

		var plugins = [];
		if(this.editmode == 'row') {
			var rowEditing = Ext.create('Ext.grid.plugin.RowEditing', this.rowEditing);
			plugins.push(rowEditing);
		}
		Ext.apply(this,{
			plugins: plugins
		});
		
		this.callParent();
		
		for(key in this.buttonsVisibility) {
			this.down('toolbar button[itemId="'+key+'"]').setVisible(this.buttonsVisibility[key]);
		}
	}
});