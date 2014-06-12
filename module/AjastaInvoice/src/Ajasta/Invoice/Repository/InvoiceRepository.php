<?php
namespace Ajasta\Invoice\Repository;

use Ajasta\Core\Repository\PaginationResult;
use Ajasta\Invoice\Entity\Invoice;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class InvoiceRepository
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
    public function find($id)
    {
        return $this->entityRepository->find($id);
    }

    /**
     * @param  int         $offset
     * @param  int         $limit
     * @param  string|null $status
     * @return PaginationResult
     */
    public function paginateAll($offset, $limit, $status = null)
    {
        $queryBuilder = $this->entityRepository->createQueryBuilder('invoice');
        $queryBuilder->innerJoin('invoice.client', 'client');
        $queryBuilder->setFirstResult($offset);
        $queryBuilder->setMaxResults($limit);
        $queryBuilder->orderBy('invoice.id', 'desc');

        switch ($status) {
            case 'paid':
                $queryBuilder->andWhere('invoice.payDate IS NOT NULL');
                break;

            case 'late':
                $queryBuilder->andWhere('invoice.payDate IS NULL');
                $queryBuilder->andWhere('invoice.dueDate IS NOT NULL');
                $queryBuilder->andWhere('invoice.dueDate < :now');
                $queryBuilder->setParameter('now', new DateTime());
                break;

            case 'sent':
                $queryBuilder->andWhere('invoice.payDate IS NULL');
                $queryBuilder->andWhere('invoice.dueDate IS NULL OR invoice.dueDate >= :now');
                $queryBuilder->andWhere('invoice.sendDate IS NOT NULL');
                $queryBuilder->setParameter('now', new DateTime());
                break;

            case 'draft':
                $queryBuilder->andWhere('invoice.payDate IS NULL');
                $queryBuilder->andWhere('invoice.dueDate IS NULL OR invoice.dueDate >= :now');
                $queryBuilder->andWhere('invoice.sendDate IS NULL');
                $queryBuilder->setParameter('now', new DateTime());
                break;
        }

        $paginator = new Paginator($queryBuilder->getQuery(), false);

        return new PaginationResult(
            $paginator->getIterator(),
            $paginator->count()
        );
    }

    /**
     * @return int
     */
    public function countAll()
    {
        $queryBuilder = $this->entityRepository->createQueryBuilder('invoice');
        $queryBuilder->select('COUNT(invoice.id)');

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
