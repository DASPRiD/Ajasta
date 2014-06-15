<?php
namespace Ajasta\Core\Hydrator\Strategy;

use DateTime;
use DateTimeZone;
use InvalidArgumentException;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class DateStrategy implements StrategyInterface
{
    /**
     * @var DateTimeZone|null
     */
    protected static $utcTimezone;

    /**
     * @param  DateTime|null $value
     * @return string|null
     */
    public function extract($value)
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof DateTime) {
            throw new InvalidArgumentException(sprintf(
                'Expected DateTime or null, got %s',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        $value->setTimezone(static::$utcTimezone ?: (static::$utcTimezone = new DateTimeZone('utc')));
        return $value->format('Y-m-d');
    }

    /**
     * @param  string|null $value
     * @return DateTime|null
     * @throws RuntimeException
     */
    public function hydrate($value)
    {
        if (empty($value)) {
            return null;
        }

        return DateTime::createFromFormat(
            '!Y-m-d',
            $value,
            static::$utcTimezone ?: (static::$utcTimezone = new DateTimeZone('utc'))
        ) ?: null;
    }
}
