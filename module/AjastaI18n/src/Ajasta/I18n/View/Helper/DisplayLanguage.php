<?php
namespace Ajasta\I18n\View\Helper;

use Locale;
use Zend\View\Helper\AbstractHelper;

class DisplayLanguage extends AbstractHelper
{
    /**
     * @param  string $locale
     * @return string
     */
    public function __invoke($locale)
    {
        return sprintf(
            '%s (%s)',
            Locale::getDisplayLanguage($locale),
            Locale::getDisplayRegion($locale)
        );
    }
}
