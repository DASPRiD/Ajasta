<?php
namespace Ajasta\Invoice\Service\InvoicePaginationStrategy;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class EntityStrategy implements StrategyInterface
{
    /**
     * @var EntityRepository
     */
    protected $invoiceRepository;

    /**
     * @param EntityRepository $invoiceRepository
     */
    public function __construct(EntityRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function paginate($offset, $limit, $status = null)
    {
        $queryBuilder = $this->invoiceRepository->createQueryBuilder('invoice');
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
            $this->getTotalResults(),
            $paginator->count()
        );
    }

    /**
     * @return int
     */
    protected function getTotalResults()
    {
        $queryBuilder = $this->invoiceRepository->createQueryBuilder('invoice');
        $queryBuilder->select('COUNT(invoice.id)');

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
