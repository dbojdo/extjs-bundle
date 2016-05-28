<?php
namespace Webit\Bundle\ExtJsBundle\StaticData;

class StaticDataExposer implements StaticDataExposerInterface
{
    /**
     *
     * @var array
     */
    private $exposers = array();

    /**
     * @return array<key, data>
     */
    public function getExposedData()
    {
        $data = array();
        foreach ($this->exposers as $exposer) {
            $data = array_merge($data, $exposer->getExposedData());
        }

        return $data;
    }

    public function registerExposer(StaticDataExposerInterface $exposer)
    {
        $this->exposers[] = $exposer;
    }
}
