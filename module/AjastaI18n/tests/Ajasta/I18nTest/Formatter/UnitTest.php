<?php
namespace Ajasta\I18nTest\Formatter;

use Ajasta\I18n\Cldr\Manager;
use Ajasta\I18n\Cldr\Reader;
use Ajasta\I18n\Formatter\Unit;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @coversDefaultClass Ajasta\I18n\Formatter\Unit
 * @covers ::<!public>
 * @covers ::__construct
 */
class UnitTest extends TestCase
{
    /**
     * @var Manager
     */
    protected $manager;

    public function setUp()
    {
        $this->manager = new Manager(
            new Reader(__DIR__ . '/../../../../data')
        );
    }

    /**
     * @return array[]
     */
    public function unitDataProvider()
    {
        return [
            ['1 hour', 1, 'duration-hour', 'long', 'en-US'],
            ['2 hours', 2, 'duration-hour', 'long', 'en-US'],
            ['1.5 hours', 1.5, 'duration-hour', 'long', 'en-US'],
            ['1.5 hours', '1.5', 'duration-hour', 'long', 'en-US'],
            ['2 hrs', 2, 'duration-hour', 'short', 'en-US'],
            ['1,5 Stunden', 1.5, 'duration-hour', 'long', 'de-DE'],
            ['8 часов', 8, 'duration-hour', 'long', 'ru-RU'],
        ];
    }

    /**
     * @covers       ::format
     * @dataProvider unitDataProvider
     * @param        string           $expected
     * @param        int|float|string $number
     * @param,       string           $unit
     * @param        string           $length
     * @param        string           $locale
     */
    public function testFormatUnit($expected, $number, $unit, $length, $locale)
    {
        $formatter = new Unit($this->manager);

        $this->assertSame(
            $expected,
            $formatter->format($number, $unit, $length, $locale)
        );
    }
}
