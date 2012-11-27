Ext.define('Webit.data.proxy.Rest', {
    extend: 'Ext.data.proxy.Rest',
    alias : 'proxy.webitrest',

    /**
     * Specialized version of buildUrl that incorporates the {@link #appendId} and {@link #format} options into the
     * generated url. Override this to provide further customizations, but remember to call the superclass buildUrl so
     * that additional parameters like the cache buster string are appended.
     * @param {Object} request
     */
    buildUrl: function(request) {
        var me        = this,
	          operation = request.operation,
	          records   = operation.records || [],
	          record    = records[0],
	          format    = me.format,
	          url       = me.getUrl(request),
	          id        = record ? record.getId() : operation.id;
        
        request.url = url;
        var selected = me.urlSelector(request);
        if(selected) {
        	url = selected;
        }
        request.url = url;
        
        return me.callParent(arguments);
    },
    urlSelector : Ext.emptyFn
});