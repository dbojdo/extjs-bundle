Ext.define('Webit.security.AccessControlable',{
	allowedRoles: ['*'],
	isAllowed: function(user) {
		if(Ext.Array.contains(this.allowedRoles,'*')) {
			return true;
		}
		
		var isAllowed = false;
		Ext.Array.each(this.allowedRoles,function(role) {
			if(user.hasRole(role)) {
				isAllowed = true;
				return false;
			}
		});
		
		return isAllowed;
	}
});
