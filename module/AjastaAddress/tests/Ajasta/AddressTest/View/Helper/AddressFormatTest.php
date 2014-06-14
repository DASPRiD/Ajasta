<?php
namespace Ajasta\AddressTest\View\Helper;

use Ajasta\Address\Entity\Address;
use Ajasta\Address\View\Helper\AddressFormat;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\View\Renderer\PhpRenderer;

/**
 * @coversDefaultClass Ajasta\Address\View\Helper\AddressFormat
 * @covers ::<!public>
 */
class AddressFormatTest extends TestCase
{
    /**
     * @var \Ajasta\Address\Service\AddressService
     */
    protected $addressService;

    /**
     * AddressFormat
     */
    protected $addressFormat;

    public function setUp()
    {
        $this->addressService = $this
            ->getMockBuilder('Ajasta\Address\Service\AddressService')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @covers ::__construct
     * @covers ::__invoke
     */
    public function testInvokeFormatsForHtml()
    {
        $address = new Address();

        $this
            ->addressService
            ->expects($this->once())
            ->method('formatAddress')
            ->with($this->equalTo($address))
            ->will($this->returnValue(['foo', '&bar']));

        $addressFormat = new AddressFormat($this->addressService);
        $addressFormat->setView(new PhpRenderer());
        $this->assertEquals("foo<br />\n&amp;bar", $addressFormat($address));
    }
}
