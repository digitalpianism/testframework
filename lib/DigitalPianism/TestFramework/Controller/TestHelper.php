<?php

class DigitalPianism_TestFramework_Controller_TestHelper {

    /**
     * @param string $module
     * @param string $controller
     * @param string $action
     */
    final protected function dispatchRequest($module, $controller, $action)
    {
        $request = Mage::app()->getRequest();
        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);

        Mage::app()->getStore()->setConfig('web/url/redirect_to_base', false);
        Mage::app()->getFrontController()->dispatch();
    }

    /**
     * @param string $module
     * @param string $controller
     * @param string $action
     */
    final public function dispatchPostRequest($module, $controller, $action)
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->dispatchRequest($module, $controller, $action);
    }

    /**
     * @param string $module
     * @param string $controller
     * @param string $action
     */
    final public function dispatchGetRequest($module, $controller, $action)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->dispatchRequest($module, $controller, $action);
    }
}
