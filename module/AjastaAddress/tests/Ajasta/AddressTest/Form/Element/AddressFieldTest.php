<?php
namespace Ajasta\AddressTest\Form\Element;

use Ajasta\Address\Form\Element\AddressField;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Filter\Null as NullFilter;

/**
 * @coversDefaultClass Ajasta\Address\Form\Element\AddressField
 * @covers ::<!public>
 */
class AddressFieldTest extends TestCase
{
    /**
     * @covers ::getInputFilterSpecification
     */
    public function testElementHasAddressFieldValidator()
    {
        $addressField = new AddressField();
        $addressField->setName('foo');
        $inputSpecs = $addressField->getInputFilterSpecification();

        $this->assertContains(
            [
                'name' => 'Ajasta\Address\Validator\AddressFieldValidator',
                'options' => ['field' => 'foo']
            ],
            $inputSpecs['validators']
        );
    }

    /**
     * @covers ::getInputFilterSpecification
     */
    public function testValueIsInitiallyTrimmed()
    {
        $addressField = new AddressField();
        $inputSpecs   = $addressField->getInputFilterSpecification();

        $this->assertSame('stringtrim', $inputSpecs['filters'][0]['name']);
    }

    /**
     * @covers ::getInputFilterSpecification
     */
    public function testEmptyValueIsNulled()
    {
        $addressField = new AddressField();
        $inputSpecs   = $addressField->getInputFilterSpecification();

        $this->assertContains(
            [
                'name' => 'null',
                'options' => ['type' => NullFilter::TYPE_STRING]
            ],
            $inputSpecs['filters']
        );
    }

    /**
     * @covers ::getInputFilterSpecification
     */
    public function testValueIsRequired()
    {
        $addressField = new AddressField();
        $inputSpecs   = $addressField->getInputFilterSpecification();

        $this->assertTrue($inputSpecs['required']);
    }

    /**
     * @covers ::getInputFilterSpecification
     */
    public function testEmptyValueIsValidated()
    {
        $addressField = new AddressField();
        $inputSpecs   = $addressField->getInputFilterSpecification();

        $this->assertTrue($inputSpecs['continue_if_empty']);
    }
}
