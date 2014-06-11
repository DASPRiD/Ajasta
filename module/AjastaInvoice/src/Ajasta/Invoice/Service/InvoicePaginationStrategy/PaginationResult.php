<?php
namespace Ajasta\Invoice\Service\InvoicePaginationStrategy;

use Ajasta\Invoice\Entity\Invoice;
use InvalidArgumentException;
use Traversable;

class PaginationResult
{
    /**
     * @var Invoice[]
     */
    protected $results;

    /**
     * @var int
     */
    protected $numTotalResults;

    /**
     * @var int
     */
    protected $numFilteredResults;

    /**
     * @param  Invoice[] $results
     * @param  int       $numTotalResults
     * @param  int       $numFilteredResults
     * @throws InvalidArgumentException
     */
    public function __construct($results, $numTotalResults, $numFilteredResults)
    {
        if (!is_array($results) && !$results instanceof Traversable) {
            throw new InvalidArgumentException(sprintf(
                'Results must be an array or Traversable, got %s',
                is_object($results) ? get_class($results) : gettype($results)
            ));
        }

        $this->results            = $results;
        $this->numTotalResults    = $numTotalResults;
        $this->numFilteredResults = $numFilteredResults;
    }

    /**
     * @return Invoice[]
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @return int
     */
    public function getNumTotalResults()
    {
        return $this->numTotalResults;
    }

    /**
     * @return int
     */
    public function getNumFilteredResults()
    {
        return $this->numFilteredResults;
    }
}
