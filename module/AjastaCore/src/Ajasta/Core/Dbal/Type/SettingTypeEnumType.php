<?php
namespace Ajasta\Core\Dbal\Type;

use Ajasta\Core\Entity\SettingType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use InvalidArgumentException;

class SettingTypeEnumType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof SettingType) {
            throw new InvalidArgumentException(sprintf(
                'Expected value of type OptionType, got %s',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        return $value->getValue();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return SettingType::get($value);
    }
}
