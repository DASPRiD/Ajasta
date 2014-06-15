<?php
namespace Ajasta\Core\Repository;

use InvalidArgumentException;
use Traversable;

class PaginationResult
{
    /**
     * @var array|Traversable
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
     * @param  object[]|Traversable $results
     * @param  int                  $numTotalResults
     * @throws InvalidArgumentException
     */
    public function __construct($results, $numTotalResults)
    {
        if (!is_array($results) && !$results instanceof Traversable) {
            throw new InvalidArgumentException(sprintf(
                'Results must be an array or Traversable, got %s',
                is_object($results) ? get_class($results) : gettype($results)
            ));
        }

        $this->results         = $results;
        $this->numTotalResults = $numTotalResults;
    }

    /**
     * @return object[]|Traversable
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
}
