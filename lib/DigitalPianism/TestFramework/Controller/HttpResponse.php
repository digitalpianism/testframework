<?php

class DigitalPianism_TestFramework_Controller_HttpResponse extends \Mage_Core_Controller_Response_Http
{

    /**
     * Test if can send headers
     *
     * @param bool $throw
     *
     * @return bool
     */
    public function canSendHeaders($throw = false)
    {
        return true;
    }

    /**
     * Send headers
     *
     * @return DigitalPianism_TestFramework_Controller_HttpResponse
     */
    public function sendHeaders()
    {
        return $this;
    }

    /**
     * Send response
     */
    public function sendResponse()
    {
        if ($this->isException() && $this->renderExceptions()) {
            $exceptions = '';
            foreach ($this->getException() as $e) {
                $exceptions .= $e->__toString()."\n";
            }
            echo $exceptions;

            return;
        }

        // Don't flush the output
        //$this->outputBody();
        // Return it instead
        return $this->_body;
    }
}
