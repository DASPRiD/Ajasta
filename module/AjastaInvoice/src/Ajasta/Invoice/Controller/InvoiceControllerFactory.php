<?php
namespace Ajasta\Invoice\Controller;

use Ajasta\Core\FactoryUtils;
use Ajasta\Invoice\Datatable\Formatter as DatatableFormatter;
use Ajasta\Invoice\Form\InvoiceForm;
use Ajasta\Invoice\Repository\InvoiceRepository;
use Ajasta\Invoice\Service\InvoiceService;
use Zend\Form\FormElementManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InvoiceControllerFactory implements FactoryInterface
{
    /**
     * @return InvoiceController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = FactoryUtils::resolveServiceLocator($serviceLocator);

        /* @var $formElementManager FormElementManager*/
        $formElementManager = $serviceLocator->get('FormElementManager');
        /* @var $invoiceRepository InvoiceRepository */
        $invoiceRepository = $serviceLocator->get('Ajasta\Invoice\Repository\InvoiceRepository');
        /* @var $invoiceService InvoiceService */
        $invoiceService = $serviceLocator->get('Ajasta\Invoice\Service\InvoiceService');
        /* @var $invoiceForm InvoiceForm */
        $invoiceForm = $formElementManager->get('Ajasta\Invoice\Form\InvoiceForm');
        /* @var $datatableFormatter DatatableFormatter*/
        $datatableFormatter = $serviceLocator->get('Ajasta\Invoice\Datatable\Formatter');

        return new InvoiceController($invoiceRepository, $invoiceService, $invoiceForm, $datatableFormatter);
    }
}
