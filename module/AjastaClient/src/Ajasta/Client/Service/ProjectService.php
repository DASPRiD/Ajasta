<?php
namespace Ajasta\Client\Service;

use Ajasta\Client\Entity\Project;
use Doctrine\Common\Persistence\ObjectManager;

class ProjectService
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
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
