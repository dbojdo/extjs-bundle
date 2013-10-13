Ext.define('Webit.data.StaticData',{
	statics: {
		data: {},
		stores: [],
		loaded: false,
		getData: function(key) {
			if(Webit.data.StaticData.loaded == false) {
				var request = this.load();
			}
			
			return Webit.data.StaticData.data[key];
		},
		load: function() {
			var request = Ext.Ajax.request({
				url: Routing.generate('webit_extjs_expose_static_data'),
				success: function(response) {
					Webit.data.StaticData.loaded = true;
					var json = Ext.decode(response.responseText);
					for(var key in json['data']) {
						Webit.data.StaticData.data[key] = json['data'][key];
					}
					Webit.data.StaticData.updateStores();
					
					return true;
				},
				scope: this
			});
			
			return request;
		},
		reload: function() {
			Webit.data.StaticData.load();
		},
		getKeys: function() {
			var keys = [];
			for(var key in Webit.data.StaticData.data) {
				keys.push(key);
			}
			
			return keys;
		},
		isStoreRegistered: function(store) {
			var registered = false;
			Ext.each(Webit.data.StaticData.stores, function(s, i) {
				if(s['store'] == store) {
					registered = true;
					return false;
				}
			});
			
			return registered;
		},
		registerStore: function(store, key) {
			if(Webit.data.StaticData.isStoreRegistered(store) == false) {
				Webit.data.StaticData.stores.push = {store: store, dataKey: key};
			}
		},
		unregisterStore: function(store) {
			Ext.each(Webit.data.StaticData.stores, function(s, i) {
				if(s['store'] == store) {
					delete Webit.data.StaticData.stores[i];
					return false;
				}
			});
		},
		updateStores: function() {
			Ext.each(Webit.data.StaticData.stores, function(s) {
				if(s['store'] && Webit.data.StaticData.data[s['dataKey']]) {
					s['store'].loadData(Webit.data.StaticData.data[s['dataKey']])
				}
			});
		}
	}
});