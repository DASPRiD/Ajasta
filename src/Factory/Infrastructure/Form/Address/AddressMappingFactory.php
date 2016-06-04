<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\Form\Address;

use Ajasta\Infrastructure\FormData\LoginFormData;
use DASPRiD\Formidable\Mapping\FieldMappingFactory;
use DASPRiD\Formidable\Mapping\ObjectMapping;
use Interop\Container\ContainerInterface;

class AddressMappingFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ObjectMapping([
            'countryCode' => FieldMappingFactory::text(),
            'recipient' => FieldMappingFactory::text(),
            'organization' => FieldMappingFactory::text(),
            'addressLine1' => FieldMappingFactory::text(),
            'addressLine2' => FieldMappingFactory::text(),
            'locality' => FieldMappingFactory::text(),
            'dependentLocality' => FieldMappingFactory::text(),
            'administrativeArea' => FieldMappingFactory::text(),
            'postalCode' => FieldMappingFactory::text(),
            'sortingCode' => FieldMappingFactory::text(),
        ], LoginFormData::class);
    }
}
