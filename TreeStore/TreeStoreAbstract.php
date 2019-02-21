<?php
namespace Webit\Bundle\ExtJsBundle\TreeStore;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Webit\Bundle\ExtJsBundle\Store\ExtJsJson;

/**
 * Webit\Bundle\ExtJsBundle\TreeStore\TreeStoreAbstract
 * @author dbojdo
 *
 */
abstract class TreeStoreAbstract implements TreeStoreInterface
{
    use ContainerAwareTrait;

    /**
     *
     * @var ObjectManager
     */
    protected $om;

    /**
     * @var array
     */
    protected $serializerGroups = array();

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function init()
    {
        // template method for init service
    }

    public function loadNode($id = null)
    {
        $id = $id ?: 'root';

        $collData = $this->fetchNode($id);

        $response = new ExtJsJson();
        $response->setData($collData);
        $response->setSerializerGroups($this->serializerGroups);

        return $response;
    }

    abstract protected function fetchNode($id);
}
