Ext.define('Webit.controller.Front',{
	extend: 'Ext.app.Controller',
	views: [
		'Webit.view.button.DeleteButton',
		'Webit.view.form.ClearableField'
	],
	init: function() {
		this.getController('Webit.controller.EditableGrid').init();	
	}
});
