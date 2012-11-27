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
	grid: null,
	model: null,
	bbar: ['->',{
		text: 'Zapisz',
		itemId: 'save'
	},{
		text: 'Anuluj',
		itemId: 'cancel',
		handler: function(btn) {
			btn.up('window').close();
		}
	}],
	initComponent: function() {
		this.addEvents('recordSave');
		this.callParent();
	},
	getModel: function() {
		return Ext.ModelManager.getModel(this.model || this.grid.getStore().model);
	}
});
