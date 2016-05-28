<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use Doctrine\ORM\EntityManager;

/**
 *
 * @author dbojdo
 *
 */
abstract class EntityStore extends ExtJsStoreAbstract implements DataClassAwareInterface
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $dataClass;

    public function __construct(array $options = array(), EntityManager $em)
    {
        parent::__construct($options);

        $this->em = $em;
    }

    /**
     * @return string
     */
    public function getDataClass()
    {
        return $this->dataClass ?: parent::getDataClass();
    }

    /**
     *
     * @param string
     */
    public function setDataClass($dataClass)
    {
        $this->dataClass = $dataClass;
    }

    /**
     *
     * @param mixed $id
     * @param mixde $queryParams
     * @return ExtJsJsonInterface
     */
    public function loadModel($id, $queryParams)
    {
        $data = $this->em->getRepository($this->getDataClass())->find($id);

        $json = new ExtJsJson();
        $json->setData($data);

        return $json;
    }

    /**
     *
     * @param \Traversable $modelListData
     * @return ExtJsJsonInterface
     */
    public function createModels(\Traversable $modelListData)
    {
        foreach ($modelListData as &$entity) {
            $this->em->persist($entity);
        }
        $this->em->flush();

        $json = new ExtJsJson();
        $json->setData($modelListData);

        return $json;
    }

    /**
     * @param \Traversable $modelListData
     * @return ExtJsJsonInterface
     */
    public function updateModels(\Traversable $modelListData)
    {
        $this->em->flush();

        $json = new ExtJsJson();
        $json->setData($modelListData);

        return $json;
    }

    /**
     *
     * @param mixed $id
     * @return ExtJsJsonInterface
     */
    public function deleteModel($id)
    {
        foreach ($id as &$entity) {
            $this->em->remove($entity);
        }
        $this->em->flush();

        $json = new ExtJsJson();
        $json->setData(true);

        return $json;
    }
}

?>
