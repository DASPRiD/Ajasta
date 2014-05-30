<?php
namespace Ajasta\Core\Form\Element;

use Collator;
use Locale;
use Zend\Form\Element\Select;

class LocaleSelect extends Select
{
    /**
     * @var array
     */
    protected static $locales = [
        'en-US',
        'de-DE',
    ];

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $valueOptions = [];

        foreach (static::$locales as $locale) {
            $valueOptions[$locale] = sprintf(
                '%s (%s)',
                Locale::getDisplayLanguage($locale),
                Locale::getDisplayRegion($locale)
            );
        }

        $collator = new Collator(Locale::getDefault());
        $collator->asort($valueOptions);

        $this->setValueOptions($valueOptions);
    }
}
