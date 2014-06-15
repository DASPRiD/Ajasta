<?php
namespace Ajasta\Core\Dbal\Type;

use DateTime;
use DateTimeZone;
use Doctrine\DBAL\Types\ConversionException;

trait UTcDateTimeTrait
{
    /**
     * @var DateTimeZone|null
     */
    protected static $utcTimezone;

    /**
     * @param  DateTime|null $value
     * @param  string        $formatString
     * @return string|null
     */
    public function doConvertToDatabaseValue($value, $formatString)
    {
        if ($value === null) {
            return null;
        }

        $value->setTimezone(self::$utcTimezone ?: (self::$utcTimezone = new DateTimeZone('utc')));
        return $value->format($formatString);
    }

    /**
     * @param  string|null $value
     * @param  string      $formatString
     * @return DateTime|null
     * @throws ConversionException
     */
    public function doConvertToPHPValue($value, $formatString)
    {
        if ($value === null) {
            return null;
        }

        $dateTime = DateTime::createFromFormat(
            '!' . $formatString,
            $value,
            self::$utcTimezone ?: (self::$utcTimezone = new DateTimeZone('utc'))
        );

        if (!$dateTime) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        return $dateTime;
    }

    /**
     * @return string
     */
    abstract protected function getName();
}
