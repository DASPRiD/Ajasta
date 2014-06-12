<?php
namespace Ajasta\Client\Repository;

use Ajasta\Client\Entity\Project;
use Doctrine\ORM\EntityRepository;

class ProjectRepository
{
    /**
     * @var EntityRepository
     */
    protected $entityRepository;

    /**
     * @param EntityRepository $entityRepsitory
     */
    public function __construct(EntityRepository $entityRepsitory)
    {
        $this->entityRepository = $entityRepsitory;
    }

    /**
     * @param  int $id
     * @return Project|null
     */
    public function find($id)
    {
        return $this->entityRepository->find($id);
    }
}
