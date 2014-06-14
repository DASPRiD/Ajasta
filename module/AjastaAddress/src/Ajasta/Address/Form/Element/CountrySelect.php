<?php
namespace Ajasta\Address\Form\Element;

use Ajasta\Address\Service\AddressService;
use Ajasta\I18n\Cldr\Manager as CldrManager;
use Zend\Form\Element\Select;

class CountrySelect extends Select
{
    /**
     * @var AddressService
     */
    protected $addressService;

    /**
     * @var CldrManager
     */
    protected $cldrManager;

    /**
     * @var array|null
     */
    protected $valueOptions = null;

    public function __construct(AddressService $addressService, CldrManager $cldrManager)
    {
        $this->addressService = $addressService;
        $this->cldrManager    = $cldrManager;

        parent::__construct(null, []);
    }

    public function getValueOptions()
    {
        if ($this->valueOptions !== null) {
            return $this->valueOptions;
        }

        $countryCodes = $this->addressService->getCountryCodes();
        $valueOptions = [];

        foreach ($countryCodes as $countryCode) {
            $valueOptions[$countryCode] = $this->cldrManager->lookupCountryName($countryCode);
        }

        $this->setValueOptions($valueOptions);

        return $this->valueOptions;
    }
}
