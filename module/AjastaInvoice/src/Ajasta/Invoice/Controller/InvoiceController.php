<?php
namespace Ajasta\Invoice\Controller;

use Ajasta\Invoice\Service\InvoiceService;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
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
     * @param InvoiceService $invoiceService
     * @param FormInterface  $invoiceForm
     */
    public function __construct(InvoiceService $invoiceService, FormInterface $invoiceForm)
    {
        $this->invoiceService = $invoiceService;
        $this->invoiceForm    = $invoiceForm;
    }

    public function indexAction()
    {
        return new ViewModel([
            'invoices' => $this->invoiceService->findAll(),
        ]);
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->invoiceForm->setData($this->getRequest()->getPost());
print_r($this->getRequest()->getPost());
exit;
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
