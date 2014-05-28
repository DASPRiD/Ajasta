<?php
namespace Ajasta\Address\Validator;

use Ajasta\Address\Service\AddressService;
use Zend\Validator\NotEmpty as NotEmptyValidator;

class AddressFieldValidator extends NotEmptyValidator
{
    const MISSING_COUNTRY_CODE = 'missingCountryCode';

    /**
     * @var AddressService
     */
    protected $addressService;

    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @param AddressService $addressService
     * @param string         $fieldName
     */
    public function __construct(AddressService $addressService, $fieldName)
    {
        $this->addressService = $addressService;
        $this->fieldName      = $fieldName;
        $this->messageTemplates[self::MISSING_COUNTRY_CODE] = 'No country was provided via context';

        parent::__construct();
    }

    /**
     * @param array|null $context
     */
    public function isValid($value, $context = null)
    {
        if (!is_array($context) || !isset($context['countryCode'])) {
            $this->error(static::MISSING_COUNTRY_CODE);
            return false;
        }

        $countryCode = trim($context['countryCode']);
        $fields      = $this->addressService->getFieldsForCountry($countryCode);

        if (!isset($fields[$this->fieldName]) || !$fields[$this->fieldName]) {
            return true;
        }

        return parent::isValid($value);
    }
}
