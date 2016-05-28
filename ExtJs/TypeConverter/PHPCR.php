<?php
namespace Webit\Bundle\ExtJsBundle\ExtJs\TypeConverter;

class PHPCR
{
    static function getExtJsType($phpcrType)
    {
        switch ($phpcrType) {
            case 'decimal':
            case 'float':
            case 'double':
                return 'float';
                break;
            case 'integer':
            case 'long':
                return 'int';
            case 'boolean':
                return 'bool';
                break;
                break;
            case 'date':
            case 'string':
                return $phpcrType;
        }
    }
}
