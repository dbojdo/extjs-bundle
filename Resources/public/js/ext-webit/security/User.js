Ext.define('Webit.security.User',{
	extend: 'Ext.data.Model',
	fields: [{
		name : 'id',
		type : 'int',
		useNull: true
	},{
		name : 'username',
		type : 'string'
	},{
		name: 'email',
		type: 'string'
	},{
		name: 'lastname',
		type : 'string'
	},{
		name: 'name',
		type: 'string'
	},{
		name: 'fullname',
		type: 'string',
		persist: false
	},{
		name: 'plain_password',
		type: 'string'
	},{
		name: 'type',
		type: 'string'
	},{
		name: 'data_completed',
		type: 'boolean',
		defaultValue: false
	},{
		name: 'enabled',
		type: 'boolean',
		defaultValue: true
	},{
		name: 'roles',
		defaultValue: []
	}],
	mixins: ['Webit.security.UserRoleMixin']
});
