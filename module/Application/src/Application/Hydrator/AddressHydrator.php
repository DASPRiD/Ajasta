<?php
namespace Application\Hydrator;

use Application\Hydrator\Strategy\NullStringStrategy;
use Application\Service\AddressService;
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
        $nullStringStrategy   = new NullStringStrategy();

        $this->addStrategy('recipient', $nullStringStrategy);
        $this->addStrategy('organization', $nullStringStrategy);
        $this->addStrategy('addressLine1', $nullStringStrategy);
        $this->addStrategy('addressLine2', $nullStringStrategy);
        $this->addStrategy('locality', $nullStringStrategy);
        $this->addStrategy('dependentLocality', $nullStringStrategy);
        $this->addStrategy('administrativeArea', $nullStringStrategy);
        $this->addStrategy('postalCode', $nullStringStrategy);
        $this->addStrategy('sortingCode', $nullStringStrategy);
    }

    public function hydrate(array $data, $object)
    {
        if (!isset($data['countryCode'])) {
            throw new RuntimeException('Missing countryCode in data');
        }

        $fields = $this->addressService->getFieldsForCountry($data['countryCode']);

        foreach ($data as $fieldName => $value) {
            if ($fieldName !== 'countryCode' && !isset($fields[$fieldName])) {
                $data[$fieldName] = '';
            }
        }

        return parent::hydrate($data, $object);
    }
}
