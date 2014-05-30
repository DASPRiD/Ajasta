<?php
namespace Ajasta\Client\Service;

use Ajasta\Client\Entity\Project;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class ProjectService
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $projectRepository;

    /**
     * @param ObjectManager    $objectManager
     * @param ObjectRepository $projectRepository
     */
    public function __construct(ObjectManager $objectManager, ObjectRepository $projectRepository)
    {
        $this->objectManager     = $objectManager;
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param  int $projectId
     * @return Project|null
     */
    public function find($projectId)
    {
        return $this->projectRepository->find($projectId);
    }

    /**
     * @param Project $project
     */
    public function persist(Project $project)
    {
        $this->objectManager->persist($project);
        $this->objectManager->flush();
    }
}
