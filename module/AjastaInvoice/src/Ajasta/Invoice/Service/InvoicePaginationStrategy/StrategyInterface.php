<?php
namespace Ajasta\Invoice\Service\InvoicePaginationStrategy;

interface StrategyInterface
{
    /**
     * @param  int         $offset
     * @param  int         $limit
     * @param  string|null $status
     * @return PaginationResult
     */
    public function paginate($offset, $limit, $status = null);
}
