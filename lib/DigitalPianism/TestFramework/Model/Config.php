<?php

class DigitalPianism_TestFramework_Model_Config extends Mage_Core_Model_Config
{

    /**
     * @var array $modelTestDoubles
     */
    private $modelTestDoubles = [];
    /**
     * @var array $resourceModelTestDoubles
     */
    private $resourceModelTestDoubles = [];

    /**
     * Set $modelTestDouble variable
     *
     * @param $modelClass
     * @param $testDouble
     */
    public function setModelTestDouble($modelClass, $testDouble)
    {
        $this->modelTestDoubles[$modelClass] = $testDouble;
    }

    /**
     * Get model instance
     *
     * @param string $modelClass
     * @param array $constructArguments
     *
     * @return mixed
     */
    public function getModelInstance($modelClass = '', $constructArguments = [])
    {
        if (isset($this->modelTestDoubles[(string)$modelClass])) {
            return $this->modelTestDoubles[(string)$modelClass];
        }

        return parent::getModelInstance($modelClass, $constructArguments);
    }

    /**
     * Set $resourceModelTestDouble variable
     *
     * @param $modelClass
     * @param $testDouble
     */
    public function setResourceModelTestDouble($modelClass, $testDouble)
    {
        $this->resourceModelTestDoubles[$modelClass] = $testDouble;
    }

    /**
     * Get resource model instance
     *
     * @param string $modelClass
     * @param array $constructArguments
     *
     * @return mixed
     */
    public function getResourceModelInstance($modelClass = '', $constructArguments = [])
    {
        if (isset($this->resourceModelTestDoubles[(string)$modelClass])) {
            return $this->resourceModelTestDoubles[(string)$modelClass];
        }

        return parent::getResourceModelInstance($modelClass, $constructArguments);
    }
}
