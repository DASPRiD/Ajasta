<?php
namespace Ajasta\Invoice\Printer;

use Ajasta\Core\Printer\FopPrinter;
use Ajasta\Invoice\Entity\Invoice;

class InvoicePrinter
{
    /**
     * @var FopPrinter
     */
    protected $fopPrinter;

    /**
     * @var XmlGenerator
     */
    protected $xmlGenerator;

    /**
     * @var string
     */
    protected $xslPath;

    /**
     * @param FopPrinter   $fopPrinter
     * @param XmlGenerator $xmlGenerator
     * @param string       $xslPath
     */
    public function __construct(FopPrinter $fopPrinter, XmlGenerator $xmlGenerator, $xslPath)
    {
        $this->fopPrinter   = $fopPrinter;
        $this->xmlGenerator = $xmlGenerator;
        $this->xslPath      = $xslPath;
    }

    /**
     * @param Invoice $invoice
     */
    public function generatePdf(Invoice $invoice, $outputPath)
    {
        $xmlPath = tempnam(sys_get_temp_dir(), 'ajasta-invoice-xml');
        $this->xmlGenerator->createXml($invoice, $xmlPath);
        $this->fopPrinter->printPdf($xmlPath, $this->xslPath, $outputPath);
        unlink($xmlPath);
    }
}
