<?php
namespace Ajasta\Core\Dbal\Type;

use Ajasta\Core\Entity\OptionType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use InvalidArgumentException;

class OptionTypeEnumType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof OptionType) {
            throw new InvalidArgumentException(sprintf(
                'Expected value of type OptionType, got %s',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        return $value->getName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return OptionType::getByName($value);
    }
}
