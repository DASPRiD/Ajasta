<?php
namespace Ajasta\AddressTest;

use Ajasta\Address\OptionsFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @coversDefaultClass Ajasta\Address\OptionsFactory
 * @covers ::<!public>
 */
class OptionsFactoryTest extends TestCase
{
    /**
     * @covers ::createService
     */
    public function testFactoryReturnsOptionsWithoutConfig()
    {
        $factory = new OptionsFactory();

        $serviceLocator = new ServiceManager();
        $serviceLocator->setService('Config', []);

        $this->assertInstanceOf(
            'Ajasta\Address\Options',
            $factory->createService($serviceLocator)
        );
    }

    /**
     * @covers ::createService
     */
    public function testFactoryReturnsOptionsWithConfig()
    {
        $factory = new OptionsFactory();

        $serviceLocator = new ServiceManager();
        $serviceLocator->setService('Config', [
            'ajasta' => [
                'address' => [
                    'locale_data_uri'    => 'foo1',
                    'data_path'          => 'foo2',
                    'country_codes_path' => 'foo3',
                ],
            ],
        ]);

        $options = $factory->createService($serviceLocator);

        $this->assertInstanceOf(
            'Ajasta\Address\Options',
            $options
        );

        $this->assertSame('foo1', $options->getLocaleDataUri());
        $this->assertSame('foo2', $options->getDataPath());
        $this->assertSame('foo3', $options->getCountryCodesPath());
    }
}
