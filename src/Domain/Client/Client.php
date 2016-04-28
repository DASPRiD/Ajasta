<?php
declare(strict_types=1);

namespace Ajasta\Domain\Client;

use Ajasta\Domain\Address\Address;
use Ajasta\Domain\CurrencyCode;
use Ajasta\Domain\Descriptor;
use Ajasta\Domain\Locale;
use Ajasta\Domain\Price;
use Ajasta\Domain\Project\Project;
use Ajasta\Domain\Unit;
use Ajasta\Domain\VatPercentage;
use Assert\Assertion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Client
{
    /**
     * @var ClientId
     */
    private $clientId;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var Descriptor
     */
    private $name;

    /**
     * @var Locale
     */
    private $locale;

    /**
     * @var CurrencyCode
     */
    private $currencyCode;

    /**
     * @var bool
     */
    private $taxable;

    /**
     * @var Unit|null
     */
    private $defaultUnit;

    /**
     * @var Price|null
     */
    private $defaultUnitPrice;

    /**
     * @var VatPercentage|null
     */
    private $vatPercentage;

    /**
     * @var Address
     */
    private $address;

    /**
     * @var Project[]|Collection
     */
    private $projects;

    private function __construct()
    {
        $this->clientId = new ClientId();
        $this->projects = new ArrayCollection();
    }

    public function getClientId() : ClientId
    {
        return $this->clientId;
    }

    public function isActive() : bool
    {
        return $this->active;
    }

    public function getName() : Descriptor
    {
        return $this->name;
    }

    public function getLocale() : Locale
    {
        return $this->locale;
    }

    public function getCurrencyCode() : CurrencyCode
    {
        return $this->currencyCode;
    }

    public function isTaxable() : bool
    {
        return $this->taxable;
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

    public function hasVatPercentage() : bool
    {
        return null !== $this->vatPercentage;
    }

    public function getVatPercentage() : VatPercentage
    {
        Assertion::notNull($this->vatPercentage);
        return $this->vatPercentage;
    }

    public function getAddress() : Address
    {
        return $this->address;
    }

    /**
     * @return Project[]
     */
    public function getProjects() : array
    {
        return $this->projects->toArray();
    }
}
