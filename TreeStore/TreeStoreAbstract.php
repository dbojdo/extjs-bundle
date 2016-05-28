<?php
namespace Webit\Bundle\ExtJsBundle\TreeStore;

use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webit\Bundle\ExtJsBundle\Store\ExtJsJson;

/**
 * Webit\Bundle\ExtJsBundle\TreeStore\TreeStoreAbstract
 * @author dbojdo
 *
 */
abstract class TreeStoreAbstract implements TreeStoreInterface, ContainerAwareInterface
{
    /**
     *
     * @var ObjectManager
     */
    protected $om;

    /**
     * @var array
     */
    protected $serializerGroups = array();

    /**
     * @var ContainerInterface
     */
    protected $container;

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

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
