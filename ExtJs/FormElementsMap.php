<?php
namespace Webit\Bundle\ExtJsBundle\ExtJs;

use Webit\Bundle\ExtJsBundle\ExtJs\TypeConverter\PHPCR;

class FormElementsMap
{
    static function getFormElementDefinition($fieldName, $phpcrType)
    {
        $arField = array(
            'xtype' => 'textfield',
            'fieldLabel' => $fieldName . ' Label',
            'name' => $fieldName
        );

        $fieldType = PHPCR::getExtJsType($phpcrType);
        switch ($fieldType) {
            case 'float':
                $arField['xtype'] = 'numberfield';
                $arField['allowDecimals'] = true;
                break;
            case 'int':
                $arField['xtype'] = 'numberfield';
                $arField['allowDecimals'] = false;
                break;
            case 'bool':
                $arField['xtype'] = 'checkbox';
                $arField['inputValue'] = 1;
                break;
            case 'date':
                $arField['xtype'] = 'datefield';
                $arField['dateFormat'] = 'Y-m-d H:i:s';
        }

        return $arField;
    }
}
