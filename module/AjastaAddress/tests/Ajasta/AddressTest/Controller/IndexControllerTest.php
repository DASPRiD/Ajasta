<?php
namespace Ajasta\AddressTest\Controller;

use Ajasta\Address\Controller\IndexController;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Mvc\Router\RouteMatch;

/**
 * @coversDefaultClass Ajasta\Address\Controller\IndexController
 * @covers ::<!public>
 */
class IndexControllerTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getAddressFieldsForCountryAction
     */
    public function testGetAddressFieldsForCountryAction()
    {
        $addressService = $this
            ->getMockBuilder('Ajasta\Address\Service\AddressService')
            ->disableOriginalConstructor()
            ->getMock();

        $addressService
            ->expects($this->once())
            ->method('getFieldsForCountry')
            ->with($this->equalTo('foo'))
            ->will($this->returnValue(['bar' => true]));

        $indexController = new IndexController($addressService);
        $indexController->getEvent()->setRouteMatch(new RouteMatch(['countryCode' => 'foo']));
        $model = $indexController->getAddressFieldsForCountryAction();

        $this->assertInstanceOf('Zend\View\Model\JsonModel', $model);
        $this->assertInternalType('array', $model->getVariable('fields'));
        $this->assertSame(['bar' => true], $model->getVariable('fields'));
    }
}
