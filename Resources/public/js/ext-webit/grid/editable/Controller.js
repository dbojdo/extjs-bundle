Ext.define('Webit.grid.editable.Controller',{
	extend: 'Ext.app.Controller',
	init : function() {
		this.control({
			'webit_grid_editable_grid[editmode="window"] button[itemId="add"]': {
				click: this.onWindowAdd
			},
			'webit_grid_editable_grid[editmode="window"] button[itemId="edit"]': {
				click: this.onWindowEdit
			},
			'webit_grid_editable_grid[editmode="row"] button[itemId="add"]': {
				click: this.onRowAdd
			},
			'webit_grid_editable_grid[editmode="row"] button[itemId="edit"]': {
				click: this.onRowEdit
			},
			'webit_grid_editable_grid button[itemId="del"]': {
				click: this.onDelete
			},
			'webit_grid_editable_edit_window button[itemId="save"]': {
				click: this.onWindowSave
			}
		});
	},
	onWindowSave: function(btn) {
		var win = btn.up('window');
		var form = btn.up('window').down('form').getForm();
		
		if(form.isValid() == false) {
			return false;
		}
		
		var r = form.getRecord();
		var phantom = r.phantom;
		
		form.updateRecord(r);
		win.getEl().mask('Zapisywanie...');
		r.save({
			callback: function(record, response) {
				win.getEl().unmask();
				if(response.success) {
					var sel = win.grid.getSelectionModel().getSelection();
					if(sel.length == 1) {
						win.grid.getStore().suspendAutoSync();
							sel[0].set(record.getData());
							win.grid.getStore().commitChanges();
						win.grid.getStore().resumeAutoSync();
						win.grid.getSelectionModel().deselectAll();
						win.grid.getSelectionModel().select(sel[0]);
					}
					
					win.fireEvent('recordSave',r,phantom);
					win.close();
				} else {
					Ext.Msg.alert('Błąd','Wystąpił błąd podczas próby zapisu.');
				}
			}
		});
	},
	onWindowAdd: function(btn) {
		var grid = btn.up('grid');

		winConfig = grid.getNewWindowConfig();
		Ext.apply(winConfig,{grid: grid});
		
		var win = Ext.create('Webit.grid.editable.EditWindow',winConfig);
		win.show();
		
		var r = Ext.create(win.getModel(),grid.getModelDefaults());
		var form = win.down('form').getForm();
		form.loadRecord(r);
	},
	onWindowEdit: function(btn) {
		var grid = btn.up('grid');
		var sel = grid.getSelectionModel().getSelection();
		if(sel.length != 1) {
			return false;
		}
		
		var winConfig = grid.getEditWindowConfig();
		Ext.apply(winConfig,{grid: grid});
		
		var win = Ext.create('Webit.grid.editable.EditWindow',winConfig);
		win.show();
		
		var form = win.down('form').getForm();
		win.getEl().mask('Ładowanie danych...');
		win.getModel().load(sel[0].getId(),{
			callback: function(r,response) {
				win.getEl().unmask();
				Ext.each(win.down('form').query('combo'),function(combo) {
					if(r.fields.containsKey(combo.getItemId())) {
						combo.getStore().insert(0,r.get(combo.getItemId()));	
					}
				});
					
				if(response.success) {
					form.loadRecord(r);
				} else {
					Ext.Msg.alert('Ładowanie dancyh','Wystąpił błąd podczas ładowania danych.');
					win.close();
				}
			}
		})
		
	},
	onRowAdd: function(btn) {
		var grid = btn.up('grid');
		
		var rowEditing = grid.getPlugin('rowEditing');
		rowEditing.cancelEdit();
		
		var r = Ext.create(grid.getStore().model,grid.getModelDefaults());
		
		grid.getStore().suspendAutoSync();
    grid.getStore().addSorted(r);
    grid.getStore().resumeAutoSync();
    
    rowEditing.startEdit(r, 0);
	},
	onRowEdit: function(btn) {
		var grid = btn.up('grid');
		var sel = grid.getSelectionModel().getSelection();
		
		var rowEditing = grid.getPlugin('rowEditing');
		rowEditing.cancelEdit();
		
		if(sel.length != 1) {
			return false;
		}
		
		var r = sel[0];
    rowEditing.startEdit(r, 0);
	},
	onDelete: function(btn) {
		var grid = btn.up('grid');
		var sel = grid.getSelectionModel().getSelection();
		
		if(sel.length != 1) {
			return false;
		}
		
		Ext.Msg.confirm(btn.confirmTitle,btn.confirmMsg,function(btnId) {
			if(btnId == 'yes') {
				sel[0].destroy({
					callback: function(r, response) {
						if(response.success) {
							grid.getStore().suspendAutoSync();
							grid.getStore().remove(sel[0]);
							grid.getStore().commitChanges();
							grid.getStore().resumeAutoSync();
						} else {
							Ext.Msg.alert('Usuwanie elementu','Wystąpił błąd podczasu próby usunięcia elementu.');
						}
					}
				});
			}
		})
	}
});