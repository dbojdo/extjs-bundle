<?php

namespace Webit\Bundle\ExtJsBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as FOS;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webit\Bundle\ExtJsBundle\Store\ExtJsJson;
use Webit\Bundle\ExtJsBundle\TreeStore\TreeStoreInterface;
use JMS\Serializer\SerializationContext;

/**
 *
 * @author dbojdo
 * @FOS\NamePrefix("webit_extjs_")
 */
final class TreeStoreController
{
    /** @var SerializerInterface */
    private $serializer;

    /** @var TreeStoreInterface */
    private $store;

    public function __construct(SerializerInterface $serializer, TreeStoreInterface $store = null)
    {
        $this->serializer = $serializer;
        $this->store = $store;
    }

    /**
     * Returns children of given node
     * @FOS\QueryParam(name="id", description="Page of the overview.")
     * @FOS\QueryParam(name="node", default="root",description="Page of the overview.")
     * @FOS\Route("/tree/load")
     *
     * @param ParamFetcher $paramFetcher
     * @return Response
     */
    public function loadNodeAction(ParamFetcher $paramFetcher)
    {
        $json = $this->store()->loadNode($paramFetcher->get('id'));
        return $this->createResponse($json);
    }

    /**
     * Return node's data
     * @FOS\QueryParam(name="id", description="Page of the overview.")
     * @FOS\QueryParam(name="node", default="root",description="Page of the overview.")
     * @FOS\Route("/tree/node-data")
     * @param ParamFetcher $paramFetcher
     * @param Request $request
     * @return Response
     */
    public function getNodeAction(ParamFetcher $paramFetcher, Request $request)
    {
        $json = $this->store()->loadNode($paramFetcher->get('node'));

        return $this->createResponse($json);
    }

    /**
     * Return node's data
     * @FOS\QueryParam(name="id", description="Page of the overview.")
     * @FOS\Route("/tree/node")
     * @param Request $request
     * @return Response
     */
    public function postNodeAction(Request $request)
    {
    }

    /**
     * Move node action
     * @FOS\QueryParam(name="id", description="Page of the overview.")
     * @FOS\Route("/tree/node")
     * @param Request $request
     * @return Response
     */
    public function putNodeAction(Request $request)
    {
        $moveAction = $this->serializer->deserialize(
            $request->getContent(),
            'Webit\Bundle\ExtJsBundle\TreeStore\TreeNodeMoveAction',
            'json'
        );

        $json = $this->store()->moveNode(
            $moveAction->getItem(),
            $moveAction->getTargetItem(),
            $moveAction->getPosition()
        );

        return $this->createResponse($json);
    }

    /**
     * Return node's data
     * @FOS\QueryParam(name="id", description="Page of the overview.")
     * @FOS\Route("/tree/node")
     */
    public function deleteNodeAction()
    {
    }

    private function createResponse(ExtJsJson $json)
    {
        $response = new Response();
        $response->headers->add(array('Content-Type' => 'application/json'));
        $response->setStatusCode(200, 'OK');
        $response->setContent($this->serializer->serialize($json, 'json', $this->getSerializerContext($json)));

        return $response;
    }

    private function getSerializerContext(ExtJsJson $json)
    {
        $arGroups = $json->getSerializerGroups();
        if (count($arGroups) > 0) {
            return  SerializationContext::create()->setGroups($json->getSerializerGroups());
        }

        return null;
    }

    /**
     * @return TreeStoreInterface
     */
    private function store()
    {
        if (!$this->store) {
            throw new \RuntimeException("Store has not been set");
        }

        return $this->store;
    }
}
