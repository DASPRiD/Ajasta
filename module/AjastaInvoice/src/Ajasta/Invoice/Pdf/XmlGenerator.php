<?php
namespace Ajasta\Invoice\Pdf;

use Ajasta\Address\Service\AddressService;
use Ajasta\Core\Printer\TranslationLoader;
use Ajasta\I18n\Formatter\Unit as UnitFormatter;
use Ajasta\Invoice\Entity\Invoice;
use IntlDateFormatter;
use NumberFormatter;
use XMLWriter;

class XmlGenerator
{
    const XML_NAMESPACE = 'https://github.com/DASPRiD/Ajasta';

    /**
     * @var AddressService
     */
    protected $addressService;

    /**
     * @var UnitFormatter
     */
    protected $unitFormatter;

    /**
     * @var TranslationLoader
     */
    protected $translationLoader;

    /**
     * @var string
     */
    protected $xsdPath;

    /**
     * @var int
     */
    protected $dateType;

    /**
     * @var IntlDateFormatter
     */
    protected $dateFormatter;

    /**
     * @var NumberFormatter
     */
    protected $numberFormatter;

    /**
     * @var NumberFormatter
     */
    protected $currencyFormatter;

    /**
     * @var NumberFormatter
     */
    protected $percentageFormatter;

    /**
     * @param FopPrinter        $fopPrinter
     * @param AddressService    $addressService
     * @param UnitFormatter     $unitFormatter
     * @param TranslationLoader $translationLoader
     * @param string            $xsdPath
     * @param int               $dateType
     */
    public function __construct(
        AddressService $addressService,
        UnitFormatter $unitFormatter,
        TranslationLoader $translationLoader,
        $xsdPath,
        $dateType
    ) {
        $this->addressService    = $addressService;
        $this->unitFormatter     = $unitFormatter;
        $this->translationLoader = $translationLoader;
        $this->xsdPath           = $xsdPath;
        $this->dateType          = $dateType;
    }

    /**
     * @param  Invoice $invoice
     * @param  string  $outputPath
     */
    public function createXml(Invoice $invoice, $outputPath)
    {
        $xmlWriter = new XMLWriter();
        $xmlWriter->openUri($outputPath);
        $xmlWriter->startDocument();
        $xmlWriter->startElementNs(null, 'invoice', static::XML_NAMESPACE);
        $xmlWriter->writeAttributeNs(
            'xsi',
            'schemaLocation',
            'http://www.w3.org/2001/XMLSchema-instance',
            sprintf('%s %s', static::XML_NAMESPACE, $this->xsdPath)
        );

        $this->initFormatters($invoice);
        $this->addGenericData($xmlWriter, $invoice);
        $this->addItems($xmlWriter, $invoice);
        $this->addSubTotal($xmlWriter, $invoice);
        $this->addDiscount($xmlWriter, $invoice);
        $this->addVat($xmlWriter, $invoice);
        $this->addTotal($xmlWriter, $invoice);
        $this->addTranslations($xmlWriter, $invoice);

        $xmlWriter->endElement();
        $xmlWriter->endDocument();
    }

    /**
     * @param Invoice $invoice
     */
    protected function initFormatters(Invoice $invoice)
    {
        $this->dateFormatter = new IntlDateFormatter(
            $invoice->getLocale(),
            $this->dateType,
            IntlDateFormatter::NONE
        );
        $this->numberFormatter     = new NumberFormatter($invoice->getLocale(), NumberFormatter::DECIMAL);
        $this->currencyFormatter   = new NumberFormatter($invoice->getLocale(), NumberFormatter::CURRENCY);
        $this->percentageFormatter = new NumberFormatter($invoice->getLocale(), NumberFormatter::PERCENT);
    }

    /**
     * @param XMLWriter $xmlWriter
     * @param Invoice   $invoice
     */
    protected function addGenericData(XMLWriter $xmlWriter, Invoice $invoice)
    {
        $xmlWriter->writeElement(
            'address',
            implode("\n", $this->addressService->formatAddress($invoice->getClient()->getAddress()))
        );

        $xmlWriter->writeElement('invoice-id', $invoice->getInvoiceNumber());
        $xmlWriter->writeElement('issue-date', $this->dateFormatter->format($invoice->getIssueDate()));

        if ($invoice->getDueDate() !== null) {
            $xmlWriter->writeElement('due-date', $this->dateFormatter->format($invoice->getDueDate()));
        }
    }

    /**
     * @param XMLWriter $xmlWriter
     * @param Invoice   $invoice
     */
    protected function addItems(XMLWriter $xmlWriter, Invoice $invoice)
    {
        $xmlWriter->startElement('items');

        foreach ($invoice->getItems() as $item) {
            $xmlWriter->startElement('item');
            $xmlWriter->writeElement('description', $item->getDescription());
            $xmlWriter->writeElement('quantity', $this->formatQuantity(
                $item->getQuantity(),
                $item->getUnit(),
                $invoice->getLocale()
            ));
            $xmlWriter->writeElement('unit-price', $this->currencyFormatter->formatCurrency(
                $item->getUnitPrice(),
                $invoice->getCurrencyCode()
            ));
            $xmlWriter->writeElement('amount', $this->currencyFormatter->formatCurrency(
                $item->getAmount(),
                $invoice->getCurrencyCode()
            ));
            $xmlWriter->endElement();
        }

        $xmlWriter->endElement();
    }

    /**
     * @param string      $quantity
     * @param string|null $unit
     * @param string      $locale
     */
    protected function formatQuantity($quantity, $unit, $locale)
    {
        if ($unit === null) {
            return $this->numberFormatter->format($quantity);
        }

        return $this->unitFormatter->format(
            $quantity,
            $unit === 'hours' ? 'duration-hour' : 'duration-day',
            'long',
            $locale
        );
    }

    /**
     * @param XMLWriter $xmlWriter
     * @param Invoice   $invoice
     */
    protected function addSubTotal(XMLWriter $xmlWriter, Invoice $invoice)
    {
        $xmlWriter->writeElement('sub-total', $this->currencyFormatter->formatCurrency(
            $invoice->getItemAmount(),
            $invoice->getCurrencyCode()
        ));
    }

    /**
     * @param XMLWriter $xmlWriter
     * @param Invoice   $invoice
     */
    protected function addDiscount(XMLWriter $xmlWriter, Invoice $invoice)
    {
        if ($invoice->getDiscount() === null) {
            return;
        }

        $xmlWriter->startElement('discount');
        $xmlWriter->writeElement('percentage', $this->percentageFormatter->format($invoice->getDiscount()));
        $xmlWriter->writeElement('amount', $this->currencyFormatter->formatCurrency(
            $invoice->getDiscountAmount(),
            $invoice->getCurrencyCode()
        ));
        $xmlWriter->writeElement('after', $this->currencyFormatter->formatCurrency(
            $invoice->getDiscountAmount(),
            $invoice->getCurrencyCode()
        ));
        $xmlWriter->endElement();
    }

    /**
     * @param XMLWriter $xmlWriter
     * @param Invoice   $invoice
     */
    protected function addVat(XMLWriter $xmlWriter, Invoice $invoice)
    {
        if ($invoice->getVat() === null) {
            return;
        }

        $xmlWriter->startElement('vat');
        $xmlWriter->writeElement('percentage', $this->percentageFormatter->format($invoice->getVat()));
        $xmlWriter->writeElement('amount', $this->currencyFormatter->formatCurrency(
            $invoice->getVatAmount(),
            $invoice->getCurrencyCode()
        ));
        $xmlWriter->endElement();
    }

    /**
     * @param XMLWriter $xmlWriter
     * @param Invoice   $invoice
     */
    protected function addTotal(XMLWriter $xmlWriter, Invoice $invoice)
    {
        $xmlWriter->writeElement('total', $this->currencyFormatter->formatCurrency(
            $invoice->getTotalAmount(),
            $invoice->getCurrencyCode()
        ));
    }

    /**
     * @param XMLWriter $xmlWriter
     * @param Invoice   $invoice
     */
    protected function addTranslations(XMLWriter $xmlWriter, Invoice $invoice)
    {
        $xmlWriter->startElement('translations');

        foreach ($this->translationLoader->getMessages($invoice->getLocale()) as $id => $message) {
            $xmlWriter->startElement('message');
            $xmlWriter->writeAttribute('id', $id);
            $xmlWriter->text($message);
            $xmlWriter->endElement();
        }

        $xmlWriter->endElement();
    }
}
