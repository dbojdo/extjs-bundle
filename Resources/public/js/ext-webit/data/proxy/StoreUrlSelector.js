Ext.ns('WebitExt.data.proxy');
WebitExt.data.proxy.StoreUrlSelector = function(routingParams, request) {
	return function(request) {
		var operation = request.operation,
    records   = operation.records || [],
    record    = records[0],
    id        = record ? record.getId() : operation.id;
    
    if(Ext.isString(routingParams)) {
    	routingParams = {
    		store : routingParams
    	};
    };
    
    if(request.url) {
    	return request.url;
    }

    if(id && operation.action == 'read') {
    	return Routing.generate('webit_extjs_get_store_item',routingParams);
    } else {
    	return Routing.generate('webit_extjs_get_store_items',routingParams);
    }
	};
};