<?php
namespace Ajasta\Invoice\Dbal\Type;

use Ajasta\Invoice\Entity\StatusEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class StatusEnumType extends StringType
{
    /**
     * @param  StatusEnum|null    $value
     * @param  AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return $value->getValue();
    }

    /**
     * @param  string|null $value
     * @param  AbstractPlatform $platform
     * @return StatusEnum|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return StatusEnum::get($value);
    }
}
