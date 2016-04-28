<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Doctrine\Type;

use Assert\Assertion;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class AbstractIdType extends Type
{
    /**
     * @var string
     */
    private $idClassName;

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getBinaryTypeDeclarationSQL([
            'length' => '16',
            'fixed' => true,
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

        Assertion::isInstanceOf($value, $this->idClassName ?: ($this->idClassName = $this->getIdClassName()));
        return $value->toBytes();
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        $className = $this->idClassName ?: ($this->idClassName = $this->getIdClassName());
        return $className::fromBytes($value);
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    abstract protected function getIdClassName() : string;
}
