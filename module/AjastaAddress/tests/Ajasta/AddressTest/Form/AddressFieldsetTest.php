<?php
namespace Ajasta\AddressTest\Form;

use Ajasta\Address\Form\AddressFieldset;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Form\Element as FormElement;

/**
 * @coversDefaultClass Ajasta\Address\Form\AddressFieldset
 * @covers ::<!public>
 */
class AddressFieldsetTest extends TestCase
{
    /**
     * @var \Ajasta\Address\Hydrator\AddressHydrator|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressHydrator;

    public function setUp()
    {
        $this->addressHydrator = $this
            ->getMockBuilder('Ajasta\Address\Hydrator\AddressHydrator')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorInjection()
    {
        $fieldset = new AddressFieldset($this->addressHydrator);
        $this->assertSame('address', $fieldset->getName());
        $this->assertSame($this->addressHydrator, $fieldset->getHydrator());
    }

    /**
     * @covers ::init()
     */
    public function testExistenceOfAllFields()
    {
        $countrySelect = new FormElement();

        $fieldset = new AddressFieldset($this->addressHydrator);
        $fieldset->getFormFactory()->getFormElementManager()->setService(
            'Ajasta\Address\Form\Element\CountrySelect',
            $countrySelect
        );
        $fieldset->init();

        $this->assertInstanceOf('Ajasta\Address\Form\Element\AddressField', $fieldset->get('recipient'));
        $this->assertInstanceOf('Ajasta\Address\Form\Element\AddressField', $fieldset->get('organization'));
        $this->assertInstanceOf('Ajasta\Address\Form\Element\AddressField', $fieldset->get('addressLine1'));
        $this->assertInstanceOf('Ajasta\Address\Form\Element\AddressField', $fieldset->get('addressLine2'));
        $this->assertInstanceOf('Ajasta\Address\Form\Element\AddressField', $fieldset->get('locality'));
        $this->assertInstanceOf('Ajasta\Address\Form\Element\AddressField', $fieldset->get('dependentLocality'));
        $this->assertInstanceOf('Ajasta\Address\Form\Element\AddressField', $fieldset->get('administrativeArea'));
        $this->assertInstanceOf('Ajasta\Address\Form\Element\AddressField', $fieldset->get('postalCode'));
        $this->assertInstanceOf('Ajasta\Address\Form\Element\AddressField', $fieldset->get('sortingCode'));
        $this->assertSame($countrySelect, $fieldset->get('countryCode'));
    }

    /**
     * @covers ::getInputFilterSpecification
     */
    public function testCountryCodeIsRequired()
    {
        $fieldset   = new AddressFieldset($this->addressHydrator);
        $inputSpecs = $fieldset->getInputFilterSpecification();

        $this->assertTrue($inputSpecs['countryCode']['required']);
    }
}
