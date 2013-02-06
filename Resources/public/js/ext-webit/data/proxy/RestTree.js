Ext.define('Webit.data.proxy.RestTree', {
    extend: 'Ext.data.proxy.Rest',
    alias : 'proxy.webitresttree',
    appendId: false,
		storeName: undefined,
		constructor: function(config) {
      var me = this;
      
      config = config || {};
      me.callParent([config]);

      var api = {
		    create  : Routing.generate('webit_extjs_post_node',{store: config.storeName}),
		    read    : Routing.generate('webit_extjs_get_node',{store: config.storeName}),
		    update  : Routing.generate('webit_extjs_put_node',{store: config.storeName}),
		    destroy : Routing.generate('webit_extjs_delete_node',{store: config.storeName})
			};

      Ext.apply(api,config.api || {});
      me.api = api;
    }
});
