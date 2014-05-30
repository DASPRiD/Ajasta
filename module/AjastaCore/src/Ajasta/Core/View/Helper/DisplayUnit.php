<?php
namespace Ajasta\Core\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DisplayUnit extends AbstractHelper
{
    /**
     * @param  string|null $unit
     * @return string
     */
    public function __invoke($unit)
    {
        switch ($unit) {
            case 'hours':
                return 'Hours';

            case 'days':
                return 'Days';
        }

        return 'None';
    }
}
