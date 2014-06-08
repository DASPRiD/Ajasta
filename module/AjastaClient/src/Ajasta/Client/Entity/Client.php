<?php
namespace Ajasta\Client\Entity;

use Ajasta\Address\Entity\Address;
use Doctrine\Common\Collections\ArrayCollection;

class Client
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var bool
     */
    protected $active = true;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $currencyCode;

    /**
     * @var bool
     */
    protected $taxable;

    /**
     * @var string|null
     */
    protected $defaultUnit;

    /**
     * @var decimal|null
     */
    protected $defaultUnitPrice;

    /**
     * @var Address
     */
    protected $address;

    /**
     * @var Project[]
     */
    protected $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    /**
     * @return id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return bool
     */
    public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * @param bool $taxable
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
    }

    /**
     * @return string|null
     */
    public function getDefaultUnit()
    {
        return $this->defaultUnit;
    }

    /**
     * @param string|null $defaultUnit
     */
    public function setDefaultUnit($defaultUnit)
    {
        $this->defaultUnit = $defaultUnit;
    }

    /**
     * @return decimal|null
     */
    public function getDefaultUnitPrice()
    {
        return $this->defaultUnitPrice;
    }

    /**
     * @param decimal|null $defaultUnitPrice
     */
    public function setDefaultUnitPrice($defaultUnitPrice)
    {
        $this->defaultUnitPrice = $defaultUnitPrice;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return Project[]
     */
    public function getProjects()
    {
        return $this->projects;
    }
}
