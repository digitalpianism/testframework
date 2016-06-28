<?php

class DigitalPianism_TestFramework_Model_Config extends Mage_Core_Model_Config
{
    private $modelTestDoubles = [];
    private $resourceModelTestDoubles = [];

    public function setModelTestDouble($modelClass, $testDouble)
    {
        $this->modelTestDoubles[$modelClass] = $testDouble;
    }

    public function getModelInstance($modelClass = '', $constructArguments = [])
    {
        if (isset($this->modelTestDoubles[(string) $modelClass])) {
            return $this->modelTestDoubles[(string) $modelClass];
        }
        return parent::getModelInstance($modelClass, $constructArguments);
    }

    public function setResourceModelTestDouble($modelClass, $testDouble)
    {
        $this->resourceModelTestDoubles[$modelClass] = $testDouble;
    }

    public function getResourceModelInstance($modelClass = '', $constructArguments = [])
    {
        if (isset($this->resourceModelTestDoubles[(string) $modelClass])) {
            return $this->resourceModelTestDoubles[(string) $modelClass];
        }
        return parent::getResourceModelInstance($modelClass, $constructArguments);
    }
}