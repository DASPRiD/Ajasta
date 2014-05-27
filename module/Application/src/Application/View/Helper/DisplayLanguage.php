<?php
namespace Application\View\Helper;

use Locale;
use Zend\View\Helper\AbstractHelper;

class DisplayLanguage extends AbstractHelper
{
    public function __invoke($locale)
    {
        return sprintf(
            '%s (%s)',
            Locale::getDisplayLanguage($locale),
            Locale::getDisplayRegion($locale)
        );
    }
}
