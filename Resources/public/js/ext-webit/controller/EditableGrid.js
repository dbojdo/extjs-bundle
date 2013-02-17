Ext.define('Webit.controller.EditableGrid',{
	extend: 'Ext.app.Controller',
	views: [
		'Webit.view.grid.EditableGrid',
		'Webit.view.grid.EditWindow'
	],
	init : function() {
		this.control({
			'webit_grid_editablegrid' : {
				selectionchange: this.onGridSelectionchange,
				afterrender: function(grid) {
					var delBtn = grid.down('button[itemId="del"]');
					if(delBtn && !delBtn.handler) {
						delBtn.setHandler(this.onDelete);
					}
				}
			},
			'webit_grid_editablegrid[editmode="window"]' : {
				// set grid toolbar's buttons' handlers
				afterrender: function(grid) {
					var addBtn = grid.down('button[itemId="add"]');
					if(addBtn && !addBtn.handler) {
						addBtn.setHandler(this.onWindowAdd);
					}
					
					var editBtn = grid.down('button[itemId="edit"]');
					if(editBtn && !editBtn.handler) {
						editBtn.setHandler(this.onWindowEdit);
					}
				}
			},
			'webit_grid_editablegrid[editmode="row"] button[itemId="add"]': {
				click: this.onRowAdd
			},
			'webit_grid_editablegrid[editmode="row"] button[itemId="edit"]': {
				click: this.onRowEdit
			},
			'webit_grid_editwindow': {
				show: function(window) {
					var saveButton = window.down('toolbar button[itemId="save"]');
					if(saveButton && !saveButton.handler) {
						saveButton.setHandler(this.onWindowSave);
					}
				}
			}
		});
	},
	onGridSelectionchange : function(sm, selected) {
		var editBtn = sm.view.ownerCt.down('button[itemId="edit"]');
		var delBtn = sm.view.ownerCt.down('button[itemId="del"]');
		
		if(editBtn) {
			editBtn.setDisabled(selected.length != 1);
		}
		
		if(delBtn) {
			delBtn.setDisabled(selected.length != 1);
		}
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
					if(sel.length == 1 && !phantom) {
						win.grid.getStore().suspendAutoSync();
							sel[0].set(record.getData());
							win.grid.getStore().commitChanges();
						win.grid.getStore().resumeAutoSync();
						win.grid.getSelectionModel().deselectAll();
						win.grid.getSelectionModel().select(sel[0]);
					} else {
						win.grid.getStore().suspendAutoSync();
						win.grid.getStore().addSorted(record);
							win.grid.getStore().commitChanges();
						win.grid.getStore().resumeAutoSync();
						win.grid.getSelectionModel().deselectAll();
					}
					
					win.grid.fireEvent('recordSave',win.grid,r,phantom);
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
		
		var win = Ext.create('Webit.view.grid.EditWindow',winConfig);
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
		
		var win = Ext.create('Webit.view.grid.EditWindow',winConfig);
		win.show();
		
		var form = win.down('form').getForm();
		win.getEl().mask('Ładowanie danych...');
		win.getModel().load(sel[0].getId(),{
			callback: function(r,response) {
				win.getEl().unmask();
				if(response.success) {
					r = r || sel[0];
					Ext.each(win.down('form').query('combo'),function(combo) {
						if(r.fields.containsKey(combo.getItemId())) {
							combo.getStore().insert(0,r.get(combo.getItemId()));	
						}
					});
				
					form.loadRecord(r);
				} else {
					Ext.Msg.alert('Ładowanie danych','Wystąpił błąd podczas ładowania danych.');
					win.close();
				}
			}
		});
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
		
		var performRemove = function(r) {
			grid.getStore().suspendAutoSync();
			grid.getStore().remove(r);
			grid.getStore().commitChanges();
			grid.getStore().resumeAutoSync();
		};
		
		if(sel[0].phantom == true) {
			performRemove(sel[0]);
			
			return true;
		}
		
		Ext.Msg.confirm(btn.confirmTitle,btn.confirmMsg,function(btnId) {
			if(btnId == 'yes') {
				sel[0].destroy({
					callback: function(r, response) {
						if(response.success) {
							performRemove(sel[0]);
						} else {
							Ext.Msg.alert('Usuwanie elementu','Wystąpił błąd podczasu próby usunięcia elementu.');
						}
					}
				});
			}
		})
	}
});