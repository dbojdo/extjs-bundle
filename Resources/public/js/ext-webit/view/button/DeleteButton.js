Ext.define('Webit.view.button.DeleteButton',{
	alias: 'widget.webit_button_deletebutton',
	extend: 'Ext.button.Button',
	itemId: 'del',
	text: '-',
	tooltip: 'Usuń element',
	confirmTitle: 'Usuwanie elementu',
	confirmMsg: 'Czy na pewno chcesz usunąć wybrany element?',
	initComponent: function() {
		this.callParent();
	}
});
