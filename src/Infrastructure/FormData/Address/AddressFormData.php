<?php
declare(strict_types = 1);

namespace Ajasta\Infrastructure\FormData\Address;

final class AddressFormData
{
    /**
     * @var string
     */
    private $countryCode;

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

    public function __construct(
        string $countryCode,
        string $recipient,
        string $organization,
        string $addressLine1,
        string $addressLine2,
        string $locality,
        string $dependentLocality,
        string $administrativeArea,
        string $postalCode,
        string $sortingCode
    ) {
        $this->countryCode = $countryCode;
        $this->recipient = $recipient;
        $this->organization = $organization;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->locality = $locality;
        $this->dependentLocality = $dependentLocality;
        $this->administrativeArea = $administrativeArea;
        $this->postalCode = $postalCode;
        $this->sortingCode = $sortingCode;
    }

}
/**
        <field name="recipient" type="string" nullable="true"/>
        <field name="organization" type="string" nullable="true"/>
        <field name="addressLine1" type="string" nullable="true"/>
        <field name="addressLine2" type="string" nullable="true"/>
        <field name="locality" type="string" nullable="true"/>
        <field name="dependentLocality" type="string" nullable="true"/>
        <field name="administrativeArea" type="string" nullable="true"/>
        <field name="postalCode" type="string" nullable="true"/>
        <field name="sortingCode" type="string" nullable="true"/>
        <field name="countryCode" type="string"/>
 */