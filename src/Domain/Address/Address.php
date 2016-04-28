<?php
declare(strict_types=1);

namespace Ajasta\Domain\Address;

final class Address
{
    /**
     * @var string
     */
    private $recipient;

    /**
     * @var string
     */
    private $organization;

    /**
     * @var string
     */
    private $addressLine1;

    /**
     * @var string
     */
    private $addressLine2;

    /**
     * @var string
     */
    private $locality;

    /**
     * @var string
     */
    private $dependentLocality;

    /**
     * @var string
     */
    private $administrativeArea;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $sortingCode;

    /**
     * @var string
     */
    private $countryCode;

    public function getRecipient() : string
    {
        return $this->recipient;
    }

    public function getOrganization() : string
    {
        return $this->organization;
    }

    public function getAddressLine1() : string
    {
        return $this->addressLine1;
    }

    public function getAddressLine2() : string
    {
        return $this->addressLine2;
    }

    public function getLocality() : string
    {
        return $this->locality;
    }

    public function getDependentLocality() : string
    {
        return $this->dependentLocality;
    }

    public function getAdministrativeArea() : string
    {
        return $this->administrativeArea;
    }

    public function getPostalCode() : string
    {
        return $this->postalCode;
    }

    public function getSortingCode() : string
    {
        return $this->sortingCode;
    }

    public function getCountryCode() : string
    {
        return $this->countryCode;
    }
}