<?php
namespace Ajasta\AddressTest;

use Ajasta\Address\Module;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @coversDefaultClass Ajasta\Address\Module
 * @covers ::<!public>
 */
class ModuleTest extends TestCase
{
    /**
     * @covers ::getConfig
     */
    public function testGetConfig()
    {
        $module = new Module();
        $this->assertInternalType('array', $module->getConfig());
    }

    /**
     * @covers ::getConsoleBanner
     */
    public function testGetConsoleBanner()
    {
        $module  = new Module();
        $console = $this->getMock('Zend\Console\Adapter\AdapterInterface');

        $consoleBanner = $module->getConsoleBanner($console);
        $this->assertContains('usage', $consoleBanner);
    }
}
