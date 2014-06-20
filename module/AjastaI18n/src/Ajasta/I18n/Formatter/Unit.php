<?php
namespace Ajasta\I18n\Formatter;

use Ajasta\I18n\Cldr\Manager as CldrManager;
use MessageFormatter;

class Unit
{
    /**
     * @var MessageFormatter[]
     */
    protected static $messageFormatters;

    /**
     * @var CldrManager
     */
    protected $cldrManager;

    /**
     * @param CldrManager $cldrManager
     */
    public function __construct(CldrManager $cldrManager)
    {
        $this->cldrManager = $cldrManager;
    }

    /**
     * @param  int|float|string $number
     * @param  string           $unit
     * @param  string           $length
     * @param  string|null      $locale
     * @return string
     */
    public function format($number, $unit, $length, $locale = null)
    {
        $unitFormats = [];

        foreach ($this->cldrManager->getUnitForms($unit, $length, $locale) as $category => $format) {
            $unitFormats[] = sprintf(
                '%s{%s}',
                $category,
                str_replace('{0}', '{0, number}', $format)
            );
        }

        $messageFormatter = $this->getMessageFormatter($locale);
        $messageFormatter->setPattern(sprintf('{0, plural, %s}', implode('', $unitFormats)));

        return $messageFormatter->format([$number]);
    }

    /**
     * @param  string $locale
     * @return MessageFormatter
     */
    protected static function getMessageFormatter($locale)
    {
        if (!isset(static::$messageFormatters[$locale])) {
            static::$messageFormatters[$locale] = new MessageFormatter($locale, ' ');
        }

        return static::$messageFormatters[$locale];
    }
}
