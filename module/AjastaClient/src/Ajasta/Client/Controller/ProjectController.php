<?php
namespace Ajasta\Client\Controller;

use Ajasta\Client\Repository\ClientRepository;
use Ajasta\Client\Repository\ProjectRepository;
use Ajasta\Client\Service\ClientService;
use Ajasta\Client\Service\ProjectService;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionController
{
    /**
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * @var ProjectService
     */
    protected $projectService;

    /**
     * @var FormInterface
     */
    protected $projectForm;

    /**
     * @param ClientRepository  $clientRepository
     * @param ProjectRepository $projectRepository
     * @param ProjectService    $projectService
     * @param FormInterface     $projectForm
     */
    public function __construct(
        ClientRepository $clientRepository,
        ProjectRepository $projectRepository,
        ProjectService $projectService,
        FormInterface $projectForm
    ) {
        $this->clientRepository  = $clientRepository;
        $this->projectRepository = $projectRepository;
        $this->projectService    = $projectService;
        $this->projectForm       = $projectForm;
    }

    public function createAction()
    {
        $client = $this->clientRepository->find($this->params('clientId'));

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
        $project = $this->projectRepository->find($this->params('projectId'));

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
