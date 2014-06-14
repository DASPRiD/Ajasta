<?php
namespace Ajasta\AddressTest;

use Ajasta\Address\Options;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @coversDefaultClass Ajasta\Address\Options
 * @covers ::<!public>
 */
class OptionsTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testDefaults()
    {
        $options = new Options();
        $this->assertSame('http://i18napis.appspot.com/address/data', $options->getLocaleDataUri());
        $this->assertStringEndsWith('src/Ajasta/Address/../../../data', $options->getDataPath());
        $this->assertStringEndsWith(
            'src/Ajasta/Address/../../../data/country-codes.php',
            $options->getCountryCodesPath()
        );
    }

    /**
     * @covers ::setLocaleDataUri
     * @covers ::getLocaleDataUri
     */
    public function testGetSetLocaleDataUri()
    {
        $options = new Options();
        $options->setLocaleDataUri('foo');
        $this->assertSame('foo', $options->getLocaleDataUri());
    }

    /**
     * @covers ::setDataPath
     * @covers ::getDataPath
     */
    public function testGetDataPath()
    {
        $options = new Options();
        $options->setDataPath('foo');
        $this->assertSame('foo', $options->getDataPath());
    }

    /**
     * @covers ::setCountryCodesPath
     * @covers ::getCountryCodesPath
     */
    public function testGetSetCountryCodesPath()
    {
        $options = new Options();
        $options->setCountryCodesPath('foo');
        $this->assertSame('foo', $options->getCountryCodesPath());
    }
}
