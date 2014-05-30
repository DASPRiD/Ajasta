<?php
namespace Ajasta\Core\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DisplayUnitPrice extends AbstractHelper
{
    /**
     * @param  string|null $unitPrice
     * @param  string      $currencyCode
     * @return string
     */
    public function __invoke($unitPrice, $currencyCode)
    {
        if ($unitPrice === null) {
            return 'None';
        }

        return $this->getView()->currencyFormat(
            $unitPrice,
            $currencyCode
        );
    }
}
