<?php
namespace Ajasta\Core\Dbal\Type;

use DateTime;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateType;

class UtcDateType extends DateType
{
    /**
     * @var DateTimeZone|null
     */
    protected static $utcTimezone;

    /**
     * @param  DateTime|null    $value
     * @param  AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $value->setTimezone(self::$utcTimezone ?: (self::$utcTimezone = new DateTimeZone('utc')));
        return $value->format($platform->getDateFormatString());
    }

    /**
     * @param  string|null $value
     * @param  AbstractPlatform $platform
     * @return DateTime|null
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $value = DateTime::createFromFormat(
            '!' . $platform->getDateFormatString(),
            $value,
            self::$utcTimezone ?: (self::$utcTimezone = new DateTimeZone('utc'))
        );

        if (!$value) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        return $value;
    }
}
