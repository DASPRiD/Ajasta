<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Doctrine\Type;

use Ajasta\Domain\Descriptor;
use Assert\Assertion;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class DescriptorType extends StringType
{
    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        Assertion::isInstanceOf($value, Descriptor::class);
        return (string) $value;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        return Descriptor::fromString($value);
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Ajasta.Descriptor';
    }
}
