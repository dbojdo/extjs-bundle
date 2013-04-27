Ext.define('Webit.form.field.ClearableField',{
	extend: 'Ext.form.FieldContainer',
	alias: 'widget.webit_form_field_clearable',
	layout: {
		type: 'hbox',
		align: 'stretch'
	},
	defaults: {
		flex: 1
	},
	readOnly: false,
	initComponent: function() {
		var items = this.items || [];
		if(items.length > 0 && items[items.length - 1].xtype != 'button') {
			Ext.apply(items[0],{
				readOnly: this.readOnly
			});
			
			items.push({
				xtype: 'button',
				text: 'x',
				width: 21,
				flex: null,
				disabled: true,
				tooltip: 'Wyczyść',
				hidden: this.readOnly,
				handler: function(btn) {
					var field = btn.prev('field');
					if(Ext.isFunction(field.clearValue)) {
						field.clearValue();
					} else {
						field.setValue(null);
					}
					
					btn.disable();
				}
			});
		}
		this.callParent();
		
		this.down('field').on('change',function(field) {
			field.next('button').enable();
		});
	}
});