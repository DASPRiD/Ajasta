<?php
namespace Ajasta\Address\Hydrator;

use Ajasta\Address\Service\AddressService;
use RuntimeException;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class AddressHydrator extends ClassMethodsHydrator
{
    /**
     * @var AddressService
     */
    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        parent::__construct(false);

        $this->addressService = $addressService;
    }

    public function hydrate(array $data, $object)
    {
        // Filters are not context aware, so we have to make this cleanup on
        // hydration. If anyone has a better idea, make a pull request!
        if (!isset($data['countryCode'])) {
            throw new RuntimeException('Missing countryCode in data');
        }

        $fields = $this->addressService->getFieldsForCountry($data['countryCode']);

        foreach ($data as $fieldName => $value) {
            if ($fieldName !== 'countryCode' && !isset($fields[$fieldName])) {
                $data[$fieldName] = null;
            }
        }

        return parent::hydrate($data, $object);
    }
}
