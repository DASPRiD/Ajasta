<?php
namespace Ajasta\Client\Controller;

use Ajasta\Client\Service\ClientService;
use Ajasta\Client\Service\ProjectService;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionController
{
    /**
     * @var ClientService
     */
    protected $clientService;

    /**
     * @var ProjectService
     */
    protected $projectService;

    /**
     * @var FormInterface
     */
    protected $projectForm;

    /**
     * @param ClientService  $clientService
     * @param ProjectService $projectService
     * @param FormInterface  $projectForm
     */
    public function __construct(
        ClientService $clientService,
        ProjectService $projectService,
        FormInterface $projectForm
    ) {
        $this->clientService  = $clientService;
        $this->projectService = $projectService;
        $this->projectForm    = $projectForm;
    }

    public function createAction()
    {
        $client = $this->clientService->find($this->params('clientId'));

        if ($client === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->projectForm->get('client')->setValue($client->getName());

        if ($this->getRequest()->isPost()) {
            $this->projectForm->setData($this->getRequest()->getPost());

            if ($this->projectForm->isValid()) {
                $project = $this->projectForm->getData();
                $project->setClient($client);
                $this->projectService->persist($project);
                $this->redirect()->toRoute(
                    'clients/show',
                    ['clientId' => $client->getId()],
                    ['fragment' => 'project-table']
                );
            }
        }

        return new ViewModel([
            'form' => $this->projectForm,
        ]);
    }

    public function editAction()
    {
        $project = $this->projectService->find($this->params('projectId'));

        if ($project === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->projectForm->get('client')->setValue($project->getClient()->getName());
        $this->projectForm->bind($project);

        if ($this->getRequest()->isPost()) {
            $this->projectForm->setData($this->getRequest()->getPost());

            if ($this->projectForm->isValid()) {
                $this->projectService->persist($this->projectForm->getData());
                $this->redirect()->toRoute(
                    'clients/show',
                    ['clientId' => $project->getClient()->getId()],
                    ['fragment' => 'project-table']
                );
            }
        }

        return new ViewModel([
            'form' => $this->projectForm,
        ]);
    }
}
