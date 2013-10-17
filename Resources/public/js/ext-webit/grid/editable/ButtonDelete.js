Ext.define('Webit.grid.editable.ButtonDelete',{
	alias: 'widget.webit_grid_editable_buttondelete',
	extend: 'Ext.button.Button',
	itemId: 'del',
	iconCls: 'fam-silk-delete',
	tooltip: 'Usuń element',
	confirmTitle: 'Usuwanie elementu',
	confirmMsg: 'Czy na pewno chcesz usunąć wybrany element?',
	initComponent: function() {
		this.callParent();
	}
});
