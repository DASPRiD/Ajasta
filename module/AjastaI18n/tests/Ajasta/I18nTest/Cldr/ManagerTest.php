<?php
namespace Ajasta\I18nTest\Cldr;

use Ajasta\I18n\Cldr\Manager;
use Ajasta\I18n\Cldr\Reader;
use Locale;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @coversDefaultClass Ajasta\I18n\Cldr\Manager
 * @covers ::<!public>
 * @covers ::__construct
 */
class ModuleTest extends TestCase
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var string
     */
    protected $originalLocale;

    public function setUp()
    {
        $this->reader         = new Reader(__DIR__ . '/../../../../data');
        $this->originalLocale = Locale::getDefault();
        Locale::setDefault('de-DE');
    }

    public function tearDown()
    {
        Locale::setDefault($this->originalLocale);
    }

    /**
     * @covers ::lookupCurrencyName
     */
    public function testLookupCurrencyNameReturnsCurrencyName()
    {
        $cldrManager = new Manager($this->reader);
        $this->assertSame('US Dollar', $cldrManager->lookupCurrencyName('USD', 'en-US'));
        $this->assertSame('Доллар США', $cldrManager->lookupCurrencyName('USD', 'ru-RU'));
    }

    /**
     * @covers ::lookupCurrencyName
     */
    public function testLookupCurrencyNameUsesDefaultLocale()
    {
        $cldrManager = new Manager($this->reader);
        $this->assertSame('US-Dollar', $cldrManager->lookupCurrencyName('USD'));
    }

    /**
     * @covers ::lookupCurrencyName
     */
    public function testLookupCurrencyNameReturnsCurrencyCodeOnUnknwonCurrencyCode()
    {
        $cldrManager = new Manager($this->reader);
        $this->assertSame('ZZZ', $cldrManager->lookupCurrencyName('ZZZ', 'en-US'));
    }

    /**
     * @covers ::lookupCurrencyName
     */
    public function testLookupCurrencyNameThrowsExceptionOnInvalidCurrencyCode()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Invalid currency code "foobar"'
        );

        $cldrManager = new Manager($this->reader);
        $cldrManager->lookupCurrencyName('foobar', 'en-US');
    }

    /**
     * @covers ::lookupCountryName
     */
    public function testLookupCountryNameReturnsCountryName()
    {
        $cldrManager = new Manager($this->reader);
        $this->assertSame('United States', $cldrManager->lookupCountryName('US', 'en-US'));
        $this->assertSame('Соединенные Штаты', $cldrManager->lookupCountryName('US', 'ru-RU'));
    }

    /**
     * @covers ::lookupCountryName
     */
    public function testLookupCountryNameUsesDefaultLocale()
    {
        $cldrManager = new Manager($this->reader);
        $this->assertSame('Vereinigte Staaten', $cldrManager->lookupCountryName('US'));
    }

    /**
     * @covers ::lookupCountryName
     */
    public function testLookupCountryNameReturnsCountryCodeOnUnknwonCountryCode()
    {
        $cldrManager = new Manager($this->reader);
        $this->assertSame('XY', $cldrManager->lookupCountryName('XY', 'en-US'));
    }

    /**
     * @covers ::lookupCountryName
     */
    public function testLookupCountryNameThrowsExceptionOnInvalidCountryCode()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Invalid country code "foobar"'
        );

        $cldrManager = new Manager($this->reader);
        $cldrManager->lookupCountryName('foobar', 'en-US');
    }

    /**
     * @covers ::getUnitForms
     */
    public function testGetUnitFormsReturnsProperArray()
    {
        $cldrManager = new Manager($this->reader);
        $this->assertSame(
            [
                'one'   => '{0} hour',
                'other' => '{0} hours',
            ],
            $cldrManager->getUnitForms('duration-hour', 'long', 'en-US')
        );
    }

    /**
     * @covers ::getUnitForms
     */
    public function testGetUnitFormsUsesDefaultLocale()
    {
        $cldrManager = new Manager($this->reader);
        $this->assertSame(
            [
                'one'   => '{0} Stunde',
                'other' => '{0} Stunden',
            ],
            $cldrManager->getUnitForms('duration-hour', 'long')
        );
    }

    /**
     * @covers ::getUnitForms
     */
    public function testGetUnitFormsThrowsExceptionOnInvalidUnit()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'No units found for length "long" and unit "foo"'
        );

        $cldrManager = new Manager($this->reader);
        $cldrManager->getUnitForms('foo', 'long', 'en-US');
    }

    /**
     * @covers ::getUnitForms
     */
    public function testGetUnitFormsThrowsExceptionOnInvalidLength()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'No units found for length "foo" and unit "duration-hour"'
        );

        $cldrManager = new Manager($this->reader);
        $cldrManager->getUnitForms('duration-hour', 'foo', 'en-US');
    }
}
