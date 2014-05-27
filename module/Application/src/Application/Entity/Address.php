<?php
namespace Application\Entity;

class Address
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $recipient;

    /**
     * @var string|null
     */
    protected $organization;

    /**
     * @var string|null
     */
    protected $addressLine1;

    /**
     * @var string|null
     */
    protected $addressLine2;

    /**
     * @var string|null
     */
    protected $locality;

    /**
     * @var string|null
     */
    protected $dependentLocality;

    /**
     * @var string|null
     */
    protected $administrativeArea;

    /**
     * @var string|null
     */
    protected $postalCode;

    /**
     * @var string|null
     */
    protected $sortingCode;

    /**
     * @var string
     */
    protected $countryCode;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param string|null $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return string|null
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param string|null $organization
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
    }

    /**
     * @return string|null
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * @param string|null $addressLine1
     */
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;
    }

    /**
     * @return string|null
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * @param string|null $addressLine2
     */
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;
    }

    /**
     * @return string|null
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * @param string|null $locality
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;
    }

    /**
     * @return string|null
     */
    public function getDependentLocality()
    {
        return $this->dependentLocality;
    }

    /**
     * @param string|null $dependentLocality
     */
    public function setDependentLocality($dependentLocality)
    {
        $this->dependentLocality = $dependentLocality;
    }

    /**
     * @return string|null
     */
    public function getAdministrativeArea()
    {
        return $this->administrativeArea;
    }

    /**
     * @param string|null $administrativeArea
     */
    public function setAdministrativeArea($administrativeArea)
    {
        $this->administrativeArea = $administrativeArea;
    }

    /**
     * @return string|null
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string|null $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string|null
     */
    public function getSortingCode()
    {
        return $this->sortingCode;
    }

    /**
     * @param string|null $sortingCode
     */
    public function setSortingCode($sortingCode)
    {
        $this->sortingCode = $sortingCode;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }
}
