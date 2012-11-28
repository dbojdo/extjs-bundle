Ext.define('Webit.security.Controller',{
	extend: 'Ext.app.Controller',
	init: function() {
		SecurityContext['user'] = Ext.create(SecurityContext['user']['model'],SecurityContext['user']['data']);
		
		this.control({
			'container' : {
				beforeadd: function(container, component) {
					return this.isAllowed(SecurityContext['user'], component);
				}
			}
		});
	},
	isAllowed: function(user, component) {
		if(Ext.isFunction(component.isAllowed)) {
			return component.isAllowed(user);
		}
		
		if(Ext.isArray(component.allowedRoles)) {
			if(Ext.Array.contains('*')) {
				return true;
			}
			
			isAllowed = false;
			Ext.Array.each(component.allowedRoles,function(role) {
				if(user.hasRole(role)) {
					isAllowed = true;
					return false;
				}
			});
			
			return isAllowed;
		}
		
		return true;
	}
});