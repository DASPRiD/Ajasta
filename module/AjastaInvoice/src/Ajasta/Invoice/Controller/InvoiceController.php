<?php
namespace Ajasta\Invoice\Controller;

use Ajasta\Invoice\Datatable\Formatter as DatatableFormatter;
use Ajasta\Invoice\Entity\Invoice;
use Ajasta\Invoice\Service\InvoiceService;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class InvoiceController extends AbstractActionController
{
    /**
     * @var InvoiceService
     */
    protected $invoiceService;

    /**
     * @var FormInterface
     */
    protected $invoiceForm;

    /**
     * @var DatatableFormatter
     */
    protected $datatableFormatter;

    /**
     * @param InvoiceService $invoiceService
     * @param FormInterface  $invoiceForm
     */
    public function __construct(
        InvoiceService $invoiceService,
        FormInterface $invoiceForm,
        DatatableFormatter $datatableFormatter
    ) {
        $this->invoiceService     = $invoiceService;
        $this->invoiceForm        = $invoiceForm;
        $this->datatableFormatter = $datatableFormatter;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function getDatatableRowsAction()
    {
        $columns = $this->params()->fromPost('columns');

        $paginationResult = $this->invoiceService->paginate(
            $this->params()->fromPost('start'),
            $this->params()->fromPost('length'),
            (!empty($columns[0]['search']['value']) ? $columns[0]['search']['value'] : null)
        );

        $response = [
            'draw'            => $this->params()->fromPost('draw'),
            'recordsTotal'    => $paginationResult->getNumTotalResults(),
            'recordsFiltered' => $paginationResult->getNumFilteredResults(),
            'data'            => [],
        ];

        foreach ($paginationResult->getResults() as $invoice) {
            $response['data'][] = $this->datatableFormatter->format($invoice);
        }

        return new JsonModel($response);
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->invoiceForm->setData($this->getRequest()->getPost());

            if ($this->invoiceForm->isValid()) {
                $invoice = $this->invoiceForm->getData();
                $this->invoiceService->persist($invoice);
                $this->redirect()->toRoute('invoices/show', ['invoiceId' => $invoice->getId()]);
            }
        }

        return new ViewModel([
            'form' => $this->invoiceForm,
        ]);
    }

    public function editAction()
    {
        $invoice = $this->invoiceService->find($this->params('invoiceId'));

        if ($invoice === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->invoiceForm->bind($invoice);

        if ($this->getRequest()->isPost()) {
            $this->invoiceForm->setData($this->getRequest()->getPost());

            if ($this->invoiceForm->isValid()) {
                $this->invoiceService->persist($this->invoiceForm->getData());
                $this->redirect()->toRoute('invoices/show', ['invoiceId' => $invoice->getId()]);
            }
        }

        return new ViewModel([
            'form' => $this->invoiceForm,
        ]);
    }

    public function showAction()
    {
        $invoice = $this->invoiceService->find($this->params('invoiceId'));

        if ($invoice === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'invoice' => $invoice,
        ]);
    }
}
