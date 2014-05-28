<?php
namespace Ajasta\Address\Form\Element;

use Ajasta\Address\Service\AddressService;
use Ajasta\I18n\Cldr\Manager as CldrManager;
use Zend\Form\Element\Select;

class CountrySelect extends Select
{
    public function __construct(AddressService $addressService, CldrManager $cldrManager)
    {
        parent::__construct(null, []);

        $countryCodes = $addressService->getCountryCodes();
        $valueOptions = [];

        foreach ($countryCodes as $countryCode) {
            $valueOptions[$countryCode] = $cldrManager->lookupCountryName($countryCode);
        }

        $this->setValueOptions($valueOptions);
    }
}
