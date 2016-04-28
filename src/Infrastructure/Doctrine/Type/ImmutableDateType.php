<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Doctrine\Type;

use Assert\Assertion;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateType;

class ImmutableDateType extends DateType
{
    /**
     * @var DateTimeZone|null
     */
    private static $utcTimezone;

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        Assertion::isInstanceOf($value, DateTimeImmutable::class);
        $value->setTimezone(self::$utcTimezone ?: (self::$utcTimezone = new DateTimeZone('utc')));
        return $value->format($platform->getDateFormatString());
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        $dateTime = DateTimeImmutable::createFromFormat(
            '!' . $platform->getDateFormatString(),
            $value,
            self::$utcTimezone ?: (self::$utcTimezone = new DateTimeZone('utc'))
        );

        if (!$dateTime) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        return $dateTime;
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
        return 'Ajasta\ImmutableDate';
    }
}
