Ext.define('Webit.controller.Front',{
	extend: 'Ext.app.Controller',
	requires: [
		'Webit.Overrides'
	],
	views: [
		'Webit.view.button.DeleteButton',
		'Webit.view.form.ClearableField'
	],
	init: function() {
		this.getController('Webit.controller.EditableGrid').init();	
	}
});
