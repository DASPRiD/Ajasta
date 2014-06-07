<?php
namespace Ajasta\Client\Controller;

use Ajasta\Client\Service\ClientService;
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
     * @param ClientService $clientService
     * @param FormInterface $clientForm
     */
    public function __construct(ClientService $clientService, FormInterface $clientForm)
    {
        $this->clientService = $clientService;
        $this->clientForm    = $clientForm;
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

    public function archiveAction()
    {
        $client = $this->clientService->find($this->params('clientId'));

        if ($client === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $client->setActive(false);
        $this->clientService->persist($client);

        return $this->redirect()->toRoute('clients');
    }

    public function activateAction()
    {
        $client = $this->clientService->find($this->params('clientId'));

        if ($client === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $client->setActive(true);
        $this->clientService->persist($client);

        return $this->redirect()->toRoute('clients/show', ['clientId' => $client->getId()]);
    }

    public function getArchivedClientsAction()
    {
        $clients = [];

        foreach ($this->clientService->findAllArchived() as $client) {
            $clients[] = [
                'name'         => $client->getName(),
                'activate_url' => $this->url()->fromRoute('clients/activate', ['clientId' => $client->getId()]),
            ];
        }

        return new JsonModel(['clients' => $clients]);
    }
}
