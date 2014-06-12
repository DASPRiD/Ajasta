<?php
namespace Ajasta\Invoice\Repository;

use Ajasta\Invoice\Entity\Invoice;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;

class InvoiceNumberIncrementerRepository
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
     * @return Invoice|null
     */
    public function findWithWriteLock($id)
    {
        return $this->entityRepository->find($id, LockMode::PESSIMISTIC_WRITE);
    }
}
