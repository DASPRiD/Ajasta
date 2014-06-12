<?php
namespace Ajasta\Client\Controller;

use Ajasta\Client\Repository\ClientRepository;
use Ajasta\Client\Service\ClientService;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ClientController extends AbstractActionController
{
    /**
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * @var ClientService
     */
    protected $clientService;

    /**
     * @var FormInterface
     */
    protected $clientForm;

    /**
     * @param ClientRepository $clientRepository
     * @param ClientService    $clientService
     * @param FormInterface    $clientForm
     */
    public function __construct(
        ClientRepository $clientRepository,
        ClientService $clientService,
        FormInterface $clientForm
    ) {
        $this->clientRepository = $clientRepository;
        $this->clientService    = $clientService;
        $this->clientForm       = $clientForm;
    }

    public function indexAction()
    {
        return new ViewModel([
            'clients' => $this->clientRepository->findAllActive(),
        ]);
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->clientForm->setData($this->getRequest()->getPost());

            if ($this->clientForm->isValid()) {
                $client = $this->clientForm->getData();
                $this->clientService->persist($client);
                $this->redirect()->toRoute('clients/show', ['clientId' => $client->getId()]);
            }
        }

        return new ViewModel([
            'form' => $this->clientForm,
        ]);
    }

    public function editAction()
    {
        $client = $this->clientRepository->find($this->params('clientId'));

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
        $client = $this->clientRepository->find($this->params('clientId'));

        if ($client === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'client' => $client,
        ]);
    }

    public function archiveAction()
    {
        $client = $this->clientRepository->find($this->params('clientId'));

        if ($client === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->clientService->archive($client);

        return $this->redirect()->toRoute('clients');
    }

    public function activateAction()
    {
        $client = $this->clientRepository->find($this->params('clientId'));

        if ($client === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->clientRepository->activate($client);

        return $this->redirect()->toRoute('clients/show', ['clientId' => $client->getId()]);
    }

    public function getArchivedClientsAction()
    {
        $clients = [];

        foreach ($this->clientRepository->findAllArchived() as $client) {
            $clients[] = [
                'name'         => $client->getName(),
                'activate_url' => $this->url()->fromRoute('clients/activate', ['clientId' => $client->getId()]),
            ];
        }

        return new JsonModel(['clients' => $clients]);
    }

    public function getDataAction()
    {
        $client = $this->clientRepository->find($this->params('clientId'));

        if ($client === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $data = [
            'id'               => $client->getId(),
            'active'           => $client->getActive(),
            'name'             => $client->getName(),
            'locale'           => $client->getLocale(),
            'currencyCode'     => $client->getCurrencyCode(),
            'taxable'          => $client->getTaxable(),
            'defaultUnit'      => $client->getDefaultUnit(),
            'defaultUnitPrice' => $client->getDefaultUnitPrice(),
            'projects'         => [],
        ];

        foreach ($client->getProjects() as $project) {
            $data['projects'][$project->getId()] = [
                'id'               => $project->getId(),
                'name'             => $project->getName(),
                'defaultUnit'      => $project->getDefaultUnit(),
                'defaultUnitPrice' => $project->getDefaultUnitPrice(),
            ];
        }

        return new JsonModel($data);
    }
}
