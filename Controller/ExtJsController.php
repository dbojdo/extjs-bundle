<?php

namespace Webit\Bundle\ExtJsBundle\Controller;

use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use Webit\Bundle\ExtJsBundle\StaticData\SecurityContextExposer;
use Webit\Bundle\ExtJsBundle\StaticData\StaticDataExposer;
use Webit\Bundle\ExtJsBundle\Store\ExtJsJson;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

final class ExtJsController extends Controller
{
    /** @var SerializerInterface */
    private $serializer;

    /** @var StaticDataExposer */
    private $staticDataExposer;

    /** @var SecurityContextExposer */
    private $securityContextExposer;

    public function __construct(
        SerializerInterface $serializer,
        StaticDataExposer $staticDataExposer,
        SecurityContextExposer $securityContextExposer
    )
    {
        $this->serializer = $serializer;
        $this->staticDataExposer = $staticDataExposer;
        $this->securityContextExposer = $securityContextExposer;
    }

    /**
     * @param string $version
     * @return Response
     */
    public function includeJSFilesAction($version = null)
    {
        $version = $version ?: $this->container->getParameter('webit_ext_js.version');

        return $this->render('WebitExtJsBundle::javascripts.html.twig', array('version' => $version));
    }

    /**
     * @param string $version
     * @return Response
     */
    public function includeCSSFilesAction($version = null)
    {
        $version = $version ?: $this->container->getParameter('webit_ext_js.version');

        return $this->render('WebitExtJsBundle::stylesheets.html.twig', array('version' => $version));
    }

    /**
     * @return Response
     */
    public function getSecurityContextAction()
    {
        $securityContext = $this->securityContextExposer->expose();
        $securityContext['user'] = $this->serializer->serialize($securityContext['user'], 'json', $this->getSerializerContext());

        $response = $this->render('WebitExtJsBundle::securitycontext.js.twig', $securityContext);
        $response->headers->set('Content-Type', 'application/javascript');

        return $response;
    }

    private function getSerializerContext()
    {
        $arGroups = array('Default', 'userBaseInfo', 'userRolesInfo');
        return SerializationContext::create()->setGroups($arGroups);
    }

    public function exposeStaticDataAction()
    {
        $data = $this->staticDataExposer->getExposedData();

        $json = new ExtJsJson();
        $json->setData($data);
        $json->setSerializerGroups(array('Default', 'generic', 'static_data_exposer'));

        $context = SerializationContext::create()->setGroups($json->getSerializerGroups());

        $response = new Response();
        $response->headers->add(array('Content-Type' => 'application/json'));
        $response->setStatusCode(200, 'OK');
        $response->setContent($this->serializer->serialize($json, 'json', $context));

        return $response;
    }
}
