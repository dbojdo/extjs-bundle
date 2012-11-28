Ext.define('Webit.security.Controller',{
	extend: 'Ext.app.Controller',
	init: function() {
		SecurityContext['user'] = Ext.create(SecurityContext['user']['model'],SecurityContext['user']['data']);
		
		this.control({
			'container' : {
				beforeadd: function(container, component) {
					if(Ext.isFunction(component.isAllowed)) {
						return component.isAllowed(SecurityContext['user']);
					}
				}
			}
		});
	}
});