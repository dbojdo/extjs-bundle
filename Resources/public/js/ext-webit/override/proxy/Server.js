Ext.define('Webit.override.proxy.Server',{
	override: 'Ext.data.proxy.Server',
	encodeFilters: function(filters) {
		var me = this;
		
		var min = [],
            length = filters.length,
            i = 0;
		Ext.each(filters, function(filter, i) {
			min[i] = me.encodeFilter(filter);
		});
        
        return this.applyEncoding(min);		
	},
	encodeFilter: function(filter) {
		var encoded = {
			property: filter.property,
			value: filter.value,
			type: this.resolveType(filter),
			comparision: this.resolveComparision(filter)
		};
		
		if(filter.params) {
			encoded.params = this.resolveParams(filter);
		}
		
		return encoded;
	},
	resolveType: function(filter) {
		if(filter.type) {
			return filter.type;
		}
		
		var c = filter.comparision || 'eq';
		if(c == 'like') {
			return 'string';
		}
		
		return 'numeric';
	},
	resolveComparision: function(filter) {
		var c = filter.comparision || 'eq';
		
		return c;
	},
	resolveParams: function(filter) {
		var params = {
			case_sensitive: filter.caseSensitive || true,
			like_wildcard: 'none',
			negation: false
		};
		Ext.apply(params, filterParams || {});
		
		return {
			params: params
		}
	}
});
