<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Doctrine\Type\User;

use Ajasta\Domain\User\PasswordHash;
use Assert\Assertion;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class PasswordHashType extends StringType
{
    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL([
            'length' => '60',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        Assertion::isInstanceOf($value, PasswordHash::class);
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

        return PasswordHash::fromHash($value);
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
        return 'Ajasta.User.PasswordHash';
    }
}
