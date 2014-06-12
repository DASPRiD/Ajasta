<?php
namespace Ajasta\Client\Repository;

use Ajasta\Client\Entity\Client;
use Doctrine\ORM\EntityRepository;

class ClientRepository
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
     * @return Client|null
     */
    public function find($id)
    {
        return $this->entityRepository->find($id);
    }

    /**
     * @return Client[]
     */
    public function findAllActive()
    {
        return $this->entityRepository->findBy(['active' => true]);
    }

    /**
     * @return Client[]
     */
    public function findAllArchived()
    {
        return $this->entityRepository->findBy(['active' => false]);
    }
}
