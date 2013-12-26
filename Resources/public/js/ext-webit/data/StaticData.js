Ext.define('Webit.data.StaticData',{
	singleton: true,
	mixins: {
        observable: 'Ext.util.Observable'
    },
    url: Routing.generate('webit_extjs_expose_static_data'),
    data: {},
	stores: [],
	loaded: false,
	loading: false,
	constructor: function (config) {
        this.mixins.observable.constructor.call(this, config);
        Ext.apply(this, config);
        
        this.addEvents(
        	'load'
        );
    },
    getData: function(key) {
		if(this.loaded == false) {
			var request = this.load();
		}
		
		return this.data[key];
	},
	load: function() {
		this.loading = true;
		var request = Ext.Ajax.request({
			url: this.url,
			success: function(response) {
				this.loading = false;
				this.loaded = true;
				var json = Ext.decode(response.responseText);
				for(var key in json['data']) {
					this.data[key] = json['data'][key];
				}
				this.updateStores();
				
				this.fireEvent('load',this);
				return true;
			},
			scope: this
		});
		
		return request;
	},
	reload: function() {
		this.load();
	},
	getKeys: function() {
		var keys = [];
		for(var key in this.data) {
			keys.push(key);
		}
		
		return keys;
	},
	isStoreRegistered: function(store) {
		var registered = false;
		Ext.each(this.stores, function(s, i) {
			if(s['store'] == store) {
				registered = true;
				return false;
			}
		});
		
		return registered;
	},
	registerStore: function(store, key) {
		if(this.isStoreRegistered(store) == false) {
			this.stores.push({store: store, dataKey: key});
		}
	},
	unregisterStore: function(store) {
		Ext.each(this.stores, function(s, i) {
			if(s['store'] == store) {
				delete this.stores[i];
				return false;
			}
		});
	},
	updateStores: function() {
		Ext.each(this.stores, function(s) {
			if(s['store'] && this.data[s['dataKey']]) {
				s['store'].loadData(this.data[s['dataKey']])
			}
		},this);
	}
});