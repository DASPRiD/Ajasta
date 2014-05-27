<?php
namespace Application\Controller;

use Application\Service\AddressService;
use Application\Service\ClientService;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ClientController extends AbstractActionController
{
    /**
     * @var ClientService
     */
    protected $clientService;

    /**
     * @var FormInterface
     */
    protected $clientForm;

    /**
     * @var AddressService
     */
    protected $addressService;

    /**
     * @param ClientService $clientService
     * @param FormInterface $clientForm
     */
    public function __construct(ClientService $clientService, FormInterface $clientForm, AddressService $addressService)
    {
        $this->clientService  = $clientService;
        $this->clientForm     = $clientForm;
        $this->addressService = $addressService;
    }

    public function indexAction()
    {
        return new ViewModel([
            'clients' => $this->clientService->findAllActive(),
        ]);
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->clientForm->setData($this->getRequest()->getPost());

            if ($this->clientForm->isValid()) {
                $this->clientService->persist($this->clientForm->getData());
                $this->redirect()->toRoute('clients/show', ['clientId' => $client->getId()]);
            }
        }

        return new ViewModel([
            'form' => $this->clientForm,
        ]);
    }

    public function editAction()
    {
        $client = $this->clientService->find($this->params('clientId'));

        if ($client === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->clientForm->bind($client);

        if ($this->getRequest()->isPost()) {
            $this->clientForm->setData($this->getRequest()->getPost());

            if ($this->clientForm->isValid()) {
                $this->clientService->persist($this->clientForm->getData());
                $this->redirect()->toRoute('clients/show', ['clientId' => $client->getId()]);
            }
        }

        return new ViewModel([
            'form' => $this->clientForm,
        ]);
    }

    public function showAction()
    {
        $client = $this->clientService->find($this->params('clientId'));

        if ($client === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'client' => $client,
        ]);
    }

    public function getAddressFieldsForCountryAction()
    {
        return new JsonModel([
            'fields' => $this->addressService->getFieldsForCountry($this->params('countryCode'))
        ]);
    }
}
