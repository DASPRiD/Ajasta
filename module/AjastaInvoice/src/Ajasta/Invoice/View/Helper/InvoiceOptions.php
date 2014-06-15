<?php
namespace Ajasta\Invoice\View\Helper;

use Ajasta\Invoice\Options;
use Zend\View\Helper\AbstractHelper;

class InvoiceOptions extends AbstractHelper
{
    /**
     * @var Options
     */
    protected $options;

    /**
     * @param Options $options
     */
    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'defaultVat'       => $this->options->getDefaultVat(),
            'defaultUnit'      => $this->options->getDefaultUnit(),
            'defaultUnitPrice' => $this->options->getDefaultUnitPrice(),
        ];
    }
}
