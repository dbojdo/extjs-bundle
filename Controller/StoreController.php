<?php

namespace Webit\Bundle\ExtJsBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as FOS;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Webit\Bundle\ExtJsBundle\Store\ExtJsJson;
use Webit\Bundle\ExtJsBundle\Store\ExtJsStoreInterface;
use JMS\Serializer\SerializationContext;

/**
 *
 * @author dbojdo
 * @FOS\NamePrefix("webit_extjs_")
 */
final class StoreController
{
    /** @var SerializerInterface */
    private $serializer;

    /** @var ExtJsStoreInterface */
    private $store;

    public function __construct(SerializerInterface $serializer, ExtJsStoreInterface $store = null)
    {
        $this->serializer = $serializer;
        $this->store = $store;
    }

    /**
     * @FOS\QueryParam(name="id", description="Page of the overview.")
     * @FOS\Route("/store/item")
     *
     * @param ParamFetcher $paramFetcher
     * @param Request $request
     * @return Response
     */
    public function getItemAction(ParamFetcher $paramFetcher, Request $request)
    {
        $json = $this->store()->loadModel($paramFetcher->get('id'), $request->query->all());

        return $this->createResponse($json);
    }

    /**
     * @FOS\QueryParam(name="page", requirements="\d+", default="1", description="Page of the overview.")
     * @FOS\QueryParam(name="limit", requirements="\d+", default="0", description="Limit")
     * @FOS\QueryParam(name="start", requirements="\d+", default="0", description="Start")
     * @FOS\QueryParam(name="sort", default="[]", description="Sort")
     * @FOS\QueryParam(name="filter", default="[]", description="Filters")
     * @FOS\QueryParam(name="query", default="", description="Searching")
     * @FOS\QueryParam(name="fields", default="[]", description="Searching fields")
     * @FOS\Route("/store/items")
     *
     * @param ParamFetcher $paramFetcher
     * @param Request $request
     * @return Response
     */
    public function getItemsAction(ParamFetcher $paramFetcher, Request $request)
    {
        $f = urldecode($paramFetcher->get('filter'));
        $filters = $this->serializer->deserialize(
            $f,
            'ArrayCollection<Webit\Bundle\ExtJsBundle\Store\Filter\Filter>',
            'json'
        );
        $filters = new \Webit\Bundle\ExtJsBundle\Store\Filter\FilterCollection($filters);

        $s = urldecode($paramFetcher->get('sort'));
        $sort = $this->serializer->deserialize(
            $s,
            'ArrayCollection<Webit\Bundle\ExtJsBundle\Store\Sorter\Sorter>',
            'json'
        );
        $sort = new \Webit\Bundle\ExtJsBundle\Store\Sorter\SorterCollection($sort);

        $json = $this->store()->getModelList(
            $request->query,
            $filters,
            $sort,
            $paramFetcher->get('page'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('start')
        );

        return $this->createResponse($json);
    }

    /**
     * @param Request $request
     * @return Response
     * @FOS\Route("/store/items")
     */
    public function postItemsAction(Request $request)
    {
        $root = $this->store()->getOption('writer.root');
        $items = $root ? $request->request->get($root) : $request->getContent();

        $dataClass = $this->store()->getDataClass();
        $desrializeClass = $dataClass ? 'ArrayCollection<' . $dataClass . '>' : 'ArrayCollection';
        $arData = $this->serializer->deserialize($items, $desrializeClass, 'json');

        $json = $this->store()->createModels(new ArrayCollection($arData));

        return $this->createResponse($json);
    } // create

    /**
     * @param Request $request
     * @return Response
     * @FOS\Route("/store/items")
     */
    public function putItemsAction(Request $request)
    {
        $store = $this->store();
        $root = $store->getOption('writer.root');

        $items = $root ? $request->request->get($root) : $request->getContent();

        $dataClass = $store->getDataClass();
        $desrializeClass = $dataClass ? 'ArrayCollection<' . $dataClass . '>' : 'ArrayCollection';
        $arData = $this->serializer->deserialize($items, $desrializeClass, 'json');

        $json = $store->updateModels(new ArrayCollection($arData));

        return $this->createResponse($json);
    } // update

    /**
     * @FOS\QueryParam(name="item", description="Page of the overview.")
     * @FOS\Route("/store/items")
     *
     * @param ParamFetcher $paramFetcher
     * @param Request $request
     * @return Response
     */
    public function deleteItemsAction(ParamFetcher $paramFetcher, Request $request)
    {
        $store = $this->store();
        $root = $store->getOption('writer.root');
        $items = $root ? $request->request->get($root) : $request->getContent();

        $dataClass = $request->getDataClass();
        $desrializeClass = $dataClass ? 'ArrayCollection<' . $dataClass . '>' : 'ArrayCollection';
        $arData = $this->serializer->deserialize($items, $desrializeClass, 'json');

        return $this->createResponse(
            $store->deleteModel($arData, $request->request->all())
        );
    }

    /**
     * @FOS\QueryParam(name="page", requirements="\d+", default="1", description="Page of the overview.")
     * @FOS\QueryParam(name="limit", requirements="\d+", default="0", description="Limit")
     * @FOS\QueryParam(name="start", requirements="\d+", default="0", description="Start")
     * @FOS\QueryParam(name="sort", default="[]", description="Sort")
     * @FOS\QueryParam(name="filter", default="[]", description="Filters")
     * @FOS\Route("/chartstore/load")
     *
     * @param ParamFetcher $paramFetcher
     * @return Response
     */
    public function getChartDataAction(ParamFetcher $paramFetcher, Request $request)
    {
        $filters = $this->serializer->deserialize(
            $paramFetcher->get('filter'),
            'ArrayCollection<Webit\Bundle\ExtJsBundle\Store\Filter\Filter>',
            'json'
        );
        $filters = new \Webit\Bundle\ExtJsBundle\Store\Filter\FilterCollection($filters);

        $sort = $this->serializer->deserialize(
            $paramFetcher->get('sort'),
            'ArrayCollection<Webit\Bundle\ExtJsBundle\Store\Sorter\Sorter>',
            'json'
        );
        $sort = new \Webit\Bundle\ExtJsBundle\Store\Sorter\SorterCollection($sort);

        $json = $this->store()->loadChartData(
            $request->query->all(),
            $filters,
            $sort,
            $paramFetcher->get('page'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('start')
        );

        return $this->createResponse($json);
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
        $context = SerializationContext::create();
        $arGroups = $json->getSerializerGroups();
        if (count($arGroups) > 0) {
            $context->setGroups($json->getSerializerGroups());
        }

        foreach ($json->getContextData() as $key => $value) {
            $context->setAttribute($key, $value);
        }

        return $context;
    }

    /**
     * @return ExtJsStoreInterface
     */
    private function store()
    {
        if (!$this->store) {
            throw new \RuntimeException("Store has not been set");
        }

        return $this->store;
    }
}
