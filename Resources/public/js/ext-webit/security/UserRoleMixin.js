Ext.define('Webit.security.UserRoleMixin',{
	hasRole: function(role) {
		var roles = this.get('roles');
		if(Ext.isArray(roles)) {
			return Ext.Array.contains(roles,role);
		}
		
		return false;
	}
});
