<?php

class DigitalPianism_TestFramework_Helper_Magento
{

    /**
     * Patch Magento autoloader
     */
    private static function patchMagentoAutoloader()
    {
        $mageErrorHandler = set_error_handler(
            function () {
                return false;
            }
        );
        set_error_handler(
            function ($errno, $errstr, $errfile) use ($mageErrorHandler) {
                if (substr($errfile, -19) === 'Varien/Autoload.php') {
                    return null;
                }

                return is_callable($mageErrorHandler) ? call_user_func_array(
                    $mageErrorHandler,
                    func_get_args()
                ) : false;
            }
        );
    }

    /**
     * Bootstrap Magento application
     */
    public static function bootstrap()
    {
        require __DIR__.'/../../../../app/Mage.php';
        self::patchMagentoAutoloader();
        self::init();
    }

    /**
     * Reset application
     */
    public function reset()
    {
        Mage::reset();
        self::init();
    }

    /**
     * Initialize application
     */
    public static function init()
    {
        Mage::app('', 'store', ['config_model' => DigitalPianism_TestFramework_Model_Config::class]);
        Mage::setIsDeveloperMode(true);
        self::patchMagentoAutoloader();
        $_SESSION = [];
    }
}
