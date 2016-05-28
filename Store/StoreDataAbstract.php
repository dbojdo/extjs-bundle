<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use JMS\Serializer\Annotation as JMS;

abstract class StoreDataAbstract
{
    /**
     *
     * @var array
     * @JMS\Exclude
     */
    protected $omitProperties = array();

    public function __construct($entity = null)
    {
        $this->setOmitProperties($omitProperties = null);
        if ($entity) {
            $this->fromEntity($entity);
        }
    }

    public function fromEntity($entity)
    {
        $refObj = new \ReflectionObject($this);
        $refEntity = new \ReflectionObject($entity);

        $arMethods = $refObj->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($arMethods as $method) {
            $propertyName = lcfirst(substr($method->getName(), 3));
            if (substr($method->getName(), 0, 3) == 'set' && in_array($propertyName, $this->omitProperties) == false) {
                $callback = array($entity, 'get' . substr($method->getName(), 3));
                if (is_callable($callback)) {
                    $this->{$method->getName()}(call_user_func($callback));
                }
            }
        }
    }

    public function fillEntity($entity)
    {
        $refObj = new \ReflectionObject($this);
        $arMethods = $refObj->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($arMethods as $method) {
            $propertyName = lcfirst(substr($method->getName(), 3));
            if (substr($method->getName(), 0, 3) == 'get' && in_array($propertyName, $this->omitProperties) == false) {
                $callback = array($entity, 'set' . $propertyName);
                if (is_callable($callback)) {
                    call_user_func($callback, $this->{$method->getName()}());
                }
            }
        }
    }

    protected function setOmitProperties(array $arProperties = null)
    {
        $arProperties = $arProperties === null ? array() : $arProperties;
        $this->omitProperties = $arProperties;
    }

    /**
     * @JMS\PostDeserialize
     */
    private function restoreOmitProperties()
    {
        $this->setOmitProperties();
    }
}
