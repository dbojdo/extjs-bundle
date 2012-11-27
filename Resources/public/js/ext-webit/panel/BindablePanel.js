Ext.define('Webit.panel.BindablePanel',{
	extend: 'Ext.panel.Panel',
	initComponent: function() {
		this.addEvents('bind');
		this.callParent();
	},
	bindItem: function(item) {
		this.bindedItem = item;
		this.fireEvent('bind',this,this.bindedItem);
	},
	getBindedItem: function() {
		return this.bindedItem;
	}
});