<?php
declare(strict_types=1);

namespace Ajasta\Domain\Project;

use Ajasta\Domain\Client\Client;
use Ajasta\Domain\Descriptor;
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
     * @var Descriptor
     */
    private $name;

    /**
     * @var Unit|null
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

    public function getProjectId() : ProjectId
    {
        return $this->projectId;
    }

    public function isActive() : bool
    {
        return $this->active;
    }

    public function getClient() : Client
    {
        return $this->client;
    }

    public function getName() : Descriptor
    {
        return $this->name;
    }

    public function hasDefaultUnit() : bool
    {
        return null !== $this->defaultUnit;
    }

    public function getDefaultUnit() : Unit
    {
        Assertion::notNull($this->defaultUnit);
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
