<?php
namespace Ajasta\Core\Hydrator\Strategy;

use Doctrine\Common\Persistence\ObjectRepository;
use RuntimeException;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class EntityStrategy implements StrategyInterface
{
    /**
     * @var ObjectRepository
     */
    protected $objectRepository;

    /**
     * @param ObjectRepository $objectRepository
     */
    public function __construct(ObjectRepository $objectRepository)
    {
        $this->objectRepository = $objectRepository;
    }

    /**
     * @param  object|null $value
     * @return int|null
     */
    public function extract($value)
    {
        if ($value === null) {
            return null;
        }

        return $value->getId();
    }

    /**
     * @param  int|null $value
     * @return object|null
     * @throws RuntimeException
     */
    public function hydrate($value)
    {
        if (empty($value)) {
            return null;
        }

        $entity = $this->objectRepository->find($value);

        if ($entity === null) {
            throw new RuntimeException(sprintf('Entity with ID "%s" not found'), $value);
        }

        return $entity;
    }
}
