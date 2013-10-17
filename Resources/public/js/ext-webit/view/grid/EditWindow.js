Ext.define('Webit.view.grid.EditWindow',{
	extend: 'Ext.window.Window',
	alias: 'widget.webit_grid_editwindow',
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
		if(this.grid && Ext.isEmpty(this.renderTo)) {
			Ext.apply(this,{
				renderTo: this.grid.getEl()
			});
		}
		
		this.callParent();
	},
	getModel: function() {
		return Ext.ModelManager.getModel(this.model || this.grid.getStore().model);
	}
});
