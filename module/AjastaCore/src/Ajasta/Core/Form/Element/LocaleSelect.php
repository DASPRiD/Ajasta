<?php
namespace Ajasta\Core\Form\Element;

use Collator;
use Locale;
use Zend\Form\Element\Select;

class LocaleSelect extends Select
{
    /**
     * @param string[] $selectableLocales
     * @param string   $defaultLocale
     */
    public function __construct(array $selectableLocales, $defaultLocale)
    {
        parent::__construct();

        $valueOptions = [];

        foreach ($selectableLocales as $locale) {
            $valueOptions[$locale] = sprintf(
                '%s (%s)',
                Locale::getDisplayLanguage($locale),
                Locale::getDisplayRegion($locale)
            );
        }

        $collator = new Collator(Locale::getDefault());
        $collator->asort($valueOptions);

        $this->setValueOptions($valueOptions);
        $this->setValue($defaultLocale);
    }
}
