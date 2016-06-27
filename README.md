# Digital Pianism Test Framework

A simple test framework module that can be used to create unit and integration tests on Magento 1.

## Prepare your module for your tests

 - Create a `Test` folder under your module folder
 - Under this `Test` folder create the following files:

`phpunit.xml.dist` with the following content:

    <?xml version="1.0"?>
    <phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
             xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.1/phpunit.xsd"
             colors="true"
             bootstrap="bootstrap.php"
             backupGlobals="false"
             verbose="true"
    >
        <testsuites>
            <testsuite name="Magento Integration Tests">
                <directory suffix="Test.php">.</directory>
            </testsuite>
        </testsuites>

    </phpunit>

Note that you can change most of the file here, the important part being the `bootstrap.php` file declaration.

`bootstrap.php` with the following content:

    <?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);

    require __DIR__ . '/../../../../../../app/Mage.php';

    function fix_error_handler()
    {
        $mageErrorHandler = set_error_handler(function () {
            return false;
        });
        set_error_handler(function ($errno, $errstr, $errfile) use ($mageErrorHandler) {
            if (substr($errfile, -19) === 'Varien/Autoload.php') {
                return null;
            }
            return is_callable($mageErrorHandler) ?
                call_user_func_array($mageErrorHandler, func_get_args()) :
                false;
        });
    }
    fix_error_handler();
    Mage::app('', 'store', ['config_model'  =>  DigitalPianism_TestFramework_Model_Config::class]);
    Mage::setIsDeveloperMode(true);
    fix_error_handler();
    $_SESSION = [];

Please note that you may have to adapt the link to `app/Mage.php` depending on your Magento structure.

## Controller test sample

Here is a sample of a controller test:

Under your `Test` folder create a `MyTest.php` (your test files must be nammed accordingly to the declaration in your `phpunit.xml.dist` file, in the example above we declared a `Test.php` suffix):

    <?php

    class Vendor_Module_Test_MyTest extends \PHPUnit_Framework_TestCase {

        public function setUp()
        {
            // Stub response to avoid headers already sent problems
            $stubResponse = new \DigitalPianism_TestFramework_Controller_HttpResponse();
            Mage::app()->setResponse($stubResponse);

            // Possible parameter
            // Mage::app()->getRequest()->setParam('myparameter', 'myvalue');

            // Use the controller helper
            $controllerTestHelper = new \DigitalPianism_TestFramework_Helper_ControllerTestHelper($this);

            // Dispatch a GET request
            $controllerTestHelper->dispatchGetRequest('route', 'controller', 'action');
            // Dispatch a POST request
            //$controllerTestHelper->dispatchPostRequest('route', 'controller', 'action');
        }

        public function testSomething()
        {
            // Get the body
            $body = Mage::app()->getResponse()->getBody(true);

            // Get the headers
            $headers = Mage::app()->getResponse()->getHeaders();

            // Get a block
            $block = Mage::app()->getLayout()->getBlock('block_name');

            // Do your tests here
        }
    }

## Using test doubles

As you may have noticed, the `bootstrap.php` injects a custom instance of the config class `DigitalPianism_TestFramework_Model_Config`

This class declares several new methods:

 - `setModelTestDouble` and `getModelTestDouble` for model test doubles
 - `setResourceModelTestDouble` and `getResourceModelTestDouble` for resource model test doubles.

To use test doubles you can do the following in your `setUp` method.

Let's say you want to check what template ID is assigned to `Mage_Core_Model_Email_Template_Mailer` when the new customer account email is sent:

    $mailer = Mage::getModel('core/email_template_mailer');
    Mage::getConfig()->setModelTestDouble('core/email_template_mailer', $mailer);

    $customer->sendNewAccountEmail();

    $this->assertSame($expectedEmailTemplateId, $mailer->getTemplateId());

## Fixtures

You can create fixtures programmatically in your code.

A good recommendation to avoid having to manually delete your fixtures is to call `Mage::getSingleton('core/resource')->getConnection('core_write')->beginTransaction();` in the `setUp` method and then call `Mage::getSingleton('core/resource')->getConnection('core_write')->rollBack();` in the `tearDown` method

