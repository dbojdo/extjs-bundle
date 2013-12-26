Ext.define('Webit.override.form.Basic', {
    override: 'Ext.form.Basic', 
    loadRecord: function(record) {
    	Ext.each(this.owner.query('combo'),function(combo) {
				if(record.fields.containsKey(combo.getItemId())) {
					if(record.get(combo.getName()) && combo.findRecordByValue(record.get(combo.getName())) == false) {
						combo.getStore().insert(0,record.get(combo.getItemId()));	
					}
				}
			});
			
			this._record = record;
      return this.setValues(record.data);
    },
    setValues: function(values, arrayField) {
	        var me = this;

	        function setVal(fieldId, val) {
	            if (arrayField) {
	                fieldId = arrayField + '.' + fieldId;
	            }
	            var field = me.findField(fieldId);
	            if (field) {
	                field.setValue(val);
	                if (me.trackResetOnLoad) {
	                    field.resetOriginalValue();
	                }
	            } else if(Ext.isObject(val)) {
	                me.setValues(val, fieldId);
	            }
	        }

	        if (Ext.isArray(values)) {
	            // array of objects
	            Ext.each(values, function(val) {
	                setVal(val.id, val.value);
	            });
	        } else {
	            // object hash
	            Ext.iterate(values, setVal);
	        }
	        return this;
	    },
	    /**
	     * Persists the values in this form into the passed {@link Ext.data.Model} object in a beginEdit/endEdit block.
	     * @param {Ext.data.Model} record The record to edit
	     * @return {Ext.form.Basic} this
	     */
	    updateRecord: function(record) {
	        var values = this.getFieldValues(),
	        name,
	        obj = {};

	        function populateObj(record, values) {
	            var obj = {},
	            name;

	            record.fields.each(function(field) {
	                name = field.name;
	                if (field.model) {
	                    var nestedValues = record.get(name);
	                    var hasValues = false;
	                    for(var v in values) {
	                        if (v.indexOf('.') > 0) {
	                            var parent = v.substr(0, v.indexOf('.'));
	                            if (parent == field.name) {
	                                var key = v.substr(v.indexOf('.') + 1);
	                                nestedValues[key] = values[v];
	                                hasValues = true;
	                            }
	                        }
	                    }

	                    if (hasValues) {
	                        obj[name] = populateObj(Ext.create(field.model), nestedValues);
	                    }
	                } else if (Ext.isDefined(values[name])) {
	                    obj[name] = values[name];
	                }
	            });
	            return obj;
	        }

	        obj = populateObj(record, values);

	        record.beginEdit();
	        record.set(obj);
	        record.endEdit();

	        return this;
	    }
});

