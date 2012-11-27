Ext.ns('Webit.data.proxy');
Webit.data.proxy.StoreUrlSelector = function(routingParams, request) {
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
    	return Routing.generate('webit_extjs_get_item',routingParams);
    } else {
    	return Routing.generate('webit_extjs_get_items',routingParams);
    }
	};
};
