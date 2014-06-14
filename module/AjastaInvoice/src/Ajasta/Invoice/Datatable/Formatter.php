<?php
namespace Ajasta\Invoice\Datatable;

use Ajasta\Invoice\Entity\Invoice;
use IntlDateFormatter;
use NumberFormatter;
use Zend\Escaper\Escaper;
use Zend\Mvc\Router\RouteInterface;

class Formatter
{
    /**
     * @var array
     */
    protected static $statusMap = [
        Invoice::STATUS_DRAFT => [
            'label' => 'Draft',
            'class' => 'default',
        ],
        Invoice::STATUS_SENT => [
            'label' => 'Sent',
            'class' => 'primary',
        ],
        Invoice::STATUS_LATE => [
            'label' => 'Late',
            'class' => 'danger',
        ],
        Invoice::STATUS_PAID => [
            'label' => 'Paid',
            'class' => 'success',
        ],
    ];

    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * @var IntlDateFormatter
     */
    protected $dateFormatter;

    /**
     * @var NumberFormatter
     */
    protected $numberFormatter;

    /**
     * @var RouteInterface
     */
    protected $router;

    /**
     * @param Escaper           $escaper
     * @param IntlDateFormatter $dateFormatter
     * @param NumberFormatter   $numberFormatter
     * @param RouteInterface    $router
     */
    public function __construct(
        Escaper $escaper,
        IntlDateFormatter $dateFormatter,
        NumberFormatter $numberFormatter,
        RouteInterface $router
    ) {
        $this->escaper         = $escaper;
        $this->dateFormatter   = $dateFormatter;
        $this->numberFormatter = $numberFormatter;
        $this->router          = $router;
    }

    /**
     * @param  Invoice $invoice
     * @return string[]
     */
    public function format(Invoice $invoice)
    {
        $statusFormat = static::$statusMap[$invoice->getStatus()];

        return [
            // Status
            sprintf(
                '<span class="label label-%s">%s</span>',
                $statusFormat['class'],
                $this->escaper->escapeHtml($statusFormat['label'])
            ),

            // Issue date
            sprintf(
                '%s<br /><small>%s</small>',
                $this->escaper->escapeHtml($this->dateFormatter->format($invoice->getIssueDate())),
                $this->escaper->escapeHtml($this->getIssueDateAddition($invoice))
            ),

            // ID
            $invoice->getInvoiceNumber(),

            // Client
            $this->escaper->escapeHtml($invoice->getClient()->getName()),

            // Amount
            $this->escaper->escapeHtml(
                $this->numberFormatter->formatCurrency($invoice->getTotalAmount(), $invoice->getCurrencyCode())
            ),

            // Options
            sprintf(
                '<a href="%s" class="btn btn-xs btn-default">Show</a>',
                $this->escaper->escapeHtmlAttr(
                    $this->router->assemble(['invoiceId' => $invoice->getId()], ['name' => 'invoices/show'])
                )
            ),
        ];
    }

    /**
     * @param  Invoice $invoice
     * @return string
     */
    protected function getIssueDateAddition(Invoice $invoice)
    {
        switch ($invoice->getStatus()) {
            case 'draft':
            case 'sent':
                if ($invoice->getDueDate() === null) {
                    return 'No due date';
                }

                $dueTime = $invoice->getDueDate()->diff($invoice->getIssueDate())->days;

                return sprintf(
                    'Due in %d %s',
                    $dueTime,
                    $dueTime === 1 ? 'day' : 'days'
                );

            case 'late':
                $lateTime = $invoice->getDueDate()->diff($invoice->getIssueDate())->days;

                return sprintf(
                    '%d %s late',
                    $lateTime,
                    $lateTime === 1 ? 'day' : 'days'
                );

            case 'paid':
                $payTime = $invoice->getPayDate()->diff($invoice->getIssueDate())->days;

                return sprintf(
                    'Paid in %d %s',
                    $payTime,
                    $payTime === 1 ? 'day' : 'days'
                );
        }
    }
}
