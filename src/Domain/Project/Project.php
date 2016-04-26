<?php
declare(strict_types=1);

namespace Ajasta\Domain\Project;

use Ajasta\Domain\Price;
use Ajasta\Domain\Unit;
use Assert\Assertion;

final class Project
{
    /**
     * @var ProjectId
     */
    private $projectId;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Name
     */
    private $name;

    /**
     * @var Unit
     */
    private $defaultUnit;

    /**
     * @var Price|null
     */
    private $defaultUnitPrice;

    private function __construct()
    {
        $this->projectId = new ProjectId();
    }

    public function isActive() : bool
    {
        return $this->active;
    }

    public function getName() : Name
    {
        return $this->name;
    }

    public function getDefaultUnit() : Unit
    {
        return $this->defaultUnit;
    }

    public function hasDefaultUnitPrice() : bool
    {
        return null !== $this->defaultUnitPrice;
    }

    public function getDefaultUnitPrice() : Price
    {
        Assertion::notNull($this->defaultUnitPrice);
        return $this->defaultUnitPrice;
    }
}
