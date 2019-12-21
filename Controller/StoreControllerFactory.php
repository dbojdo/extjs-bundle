<?php

namespace Webit\Bundle\ExtJsBundle\Controller;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Webit\Bundle\ExtJsBundle\Store\ExtJsStoreInterface;
use Webit\Bundle\ExtJsBundle\TreeStore\TreeStoreInterface;

final class StoreControllerFactory
{
    /** @var ContainerInterface */
    private $container;

    /** @var SerializerInterface */
    private $serializer;

    /** @var RequestStack */
    private $requestStack;

    public function __construct(ContainerInterface $container, SerializerInterface $serializer, RequestStack $requestStack)
    {
        $this->container = $container;
        $this->serializer = $serializer;
        $this->requestStack = $requestStack;
    }

    /**
     * @return StoreController
     */
    public function createStoreController()
    {
        $store = $this->findStore();
        if ($store && !($store instanceof ExtJsStoreInterface)) {
            return null;
        }

        return new StoreController($this->serializer, $store);

    }

    /**
     * @return TreeStoreController
     */
    public function createTreeStoreController()
    {
        $store = $this->findStore();
        if ($store && !($store instanceof TreeStoreInterface)) {
            return null;
        }

        return new TreeStoreController($this->serializer, $store);
    }

    /**
     * @return ExtJsStoreInterface|TreeStoreInterface
     */
    private function findStore()
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            return null;
        }

        $storeName = $request->get('store');
        if (!$storeName) {
            return null;
        }

        return $this->container->get($storeName);
    }
}