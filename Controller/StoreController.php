<?php
namespace Webit\Bundle\ExtJsBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as FOS;
use Symfony\Component\HttpFoundation\Response;
use Webit\Bundle\ExtJsBundle\Store\ExtJsJson;
use Webit\Bundle\ExtJsBundle\Store\ExtJsStoreInterface;
use JMS\Serializer\SerializationContext;

/**
 *
 * @author dbojdo
 * @FOS\NamePrefix("webit_extjs_")
 */
class StoreController extends FOSRestController
{
    /**
     *
     * @var ExtJsStoreInterface
     */
    protected $store;

    /**
     * @FOS\QueryParam(name="id", description="Page of the overview.")
     * @FOS\Route("/store/item")
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return Response
     */
    public function getItemAction(ParamFetcher $paramFetcher)
    {
        $json = $this->getStore()->loadModel($paramFetcher->get('id'), $this->getRequest()->query->all());

        $r = $this->createResponse($json);

        return $r;
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
     * @return Response
     */
    public function getItemsAction(ParamFetcher $paramFetcher)
    {
        $f = urldecode($paramFetcher->get('filter'));
        $filters = $this->container->get('serializer')->deserialize(
            $f,
            'ArrayCollection<Webit\Bundle\ExtJsBundle\Store\Filter\Filter>',
            'json'
        );
        $filters = new \Webit\Bundle\ExtJsBundle\Store\Filter\FilterCollection($filters);

        $s = urldecode($paramFetcher->get('sort'));
        $sort = $this->container->get('serializer')->deserialize(
            $s,
            'ArrayCollection<Webit\Bundle\ExtJsBundle\Store\Sorter\Sorter>',
            'json'
        );
        $sort = new \Webit\Bundle\ExtJsBundle\Store\Sorter\SorterCollection($sort);

        $json = $this->getStore()->getModelList(
            $this->getRequest()->query,
            $filters,
            $sort,
            $paramFetcher->get('page'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('start')
        );

        $r = $this->createResponse($json);

        return $r;
    }

    /**
     *
     * @FOS\Route("/store/items")
     */
    public function postItemsAction()
    {
        $root = $this->getStore()->getOption('writer.root');
        $items = $root ? $this->getRequest()->request->get($root) : $this->getRequest()->getContent();

        $dataClass = $this->getStore()->getDataClass();
        $desrializeClass = $dataClass ? 'ArrayCollection<' . $dataClass . '>' : 'ArrayCollection';
        $arData = $this->container->get('serializer')->deserialize($items, $desrializeClass, 'json');

        $json = $this->getStore()->createModels(new ArrayCollection($arData));

        $r = $this->createResponse($json);

        return $r;
    } // create

    /**
     * @FOS\Route("/store/items")
     */
    public function putItemsAction()
    {
        $root = $this->getStore()->getOption('writer.root');

        $items = $root ? $this->getRequest()->request->get($root) : $this->getRequest()->getContent();

        $dataClass = $this->getStore()->getDataClass();
        $desrializeClass = $dataClass ? 'ArrayCollection<' . $dataClass . '>' : 'ArrayCollection';
        $arData = $this->container->get('serializer')->deserialize($items, $desrializeClass, 'json');

        $json = $this->getStore()->updateModels(new ArrayCollection($arData));

        $r = $this->createResponse($json);

        return $r;
    } // update

    /**
     * @FOS\QueryParam(name="item", description="Page of the overview.")
     * @FOS\Route("/store/items")
     *
     * @param ParamFetcher $paramFetcher
     * @return Response
     */
    public function deleteItemsAction(ParamFetcher $paramFetcher)
    {
        $root = $this->getStore()->getOption('writer.root');
        $items = $root ? $this->getRequest()->request->get($root) : $this->getRequest()->getContent();

        $dataClass = $this->getStore()->getDataClass();
        $desrializeClass = $dataClass ? 'ArrayCollection<' . $dataClass . '>' : 'ArrayCollection';
        $arData = $this->container->get('serializer')->deserialize($items, $desrializeClass, 'json');

        $json = $this->getStore()->deleteModel($arData, $this->getRequest()->request->all());

        $r = $this->createResponse($json);

        return $r;
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
    public function getChartDataAction(ParamFetcher $paramFetcher)
    {
        $filters = $this->container->get('serializer')->deserialize(
            $paramFetcher->get('filter'),
            'ArrayCollection<Webit\Bundle\ExtJsBundle\Store\Filter\Filter>',
            'json'
        );
        $filters = new \Webit\Bundle\ExtJsBundle\Store\Filter\FilterCollection($filters);

        $sort = $this->container->get('serializer')->deserialize(
            $paramFetcher->get('sort'),
            'ArrayCollection<Webit\Bundle\ExtJsBundle\Store\Sorter\Sorter>',
            'json'
        );
        $sort = new \Webit\Bundle\ExtJsBundle\Store\Sorter\SorterCollection($sort);

        $json = $this->getStore()->loadChartData(
            $this->getRequest()->query->all(),
            $filters,
            $sort,
            $paramFetcher->get('page'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('start')
        );

        $r = $this->createResponse($json);

        return $r;
    }

    protected function getStore()
    {
        if (is_null($this->store)) {
            $this->setStoreService();
        }

        return $this->store;
    }

    protected function setStoreService()
    {
        $storeId = $this->getRequest()->query->get('store');
        $this->store = $this->findStoreService($storeId);
    }

    /**
     *
     * @param string $storeId
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @return \Webit\Bundle\ExtJsBundle\Store\ExtJsStoreInterface
     */
    protected function findStoreService($storeId)
    {
        if ($this->container->has($storeId) == false) {
            throw new \RuntimeException('Required service couldn\'t be found is service container.');
        }

        $storeService = $this->container->get($storeId);

        if (($storeService instanceof ExtJsStoreInterface) == false) {
            throw new \InvalidArgumentException('Service must be instance of ExtJsStoreInterface.');
        }

        return $storeService;
    }

    private function createResponse(ExtJsJson $json)
    {
        $r = new Response();
        $r->headers->add(array('Content-Type' => 'application/json'));
        $r->setStatusCode(200, 'OK');
        $r->setContent($this->get('serializer')->serialize($json, 'json', $this->getSerializerContext($json)));

        return $r;
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
}
