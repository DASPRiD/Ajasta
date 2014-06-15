<?php
namespace Ajasta\Core\Dbal\Type;

use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

class UtcDateTimeType extends DateTimeType
{
    use UtcDateTimeTrait;

    /**
     * @param  DateTime|null    $value
     * @param  AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $this->doConvertToDatabaseValue($value, $platform->getDateTimeFormatString());
    }

    /**
     * @param  string|null $value
     * @param  AbstractPlatform $platform
     * @return DateTime|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $this->doConvertToPHPValue($value, $platform->getDateTimeFormatString());
    }
}
