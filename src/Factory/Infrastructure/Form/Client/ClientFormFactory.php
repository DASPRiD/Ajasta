<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\Form\Client;

use Ajasta\Infrastructure\FormData\LoginFormData;
use DASPRiD\Formidable\Form;
use DASPRiD\Formidable\Mapping\FieldMappingFactory;
use DASPRiD\Formidable\Mapping\ObjectMapping;
use Interop\Container\ContainerInterface;

class ClientFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Form(new ObjectMapping([
            'name' => FieldMappingFactory::text(1),
            'locale' => FieldMappingFactory::text(),
            'currencyCode' => FieldMappingFactory::text(),
            'taxable' => FieldMappingFactory::boolean(),
            'defaultUnit' => FieldMappingFactory::text(),
            'defaultUnitPrice' => FieldMappingFactory::text(),
            'vatPercentage' => FieldMappingFactory::text(),
            'address' => $container->get('Ajasta.Form.Address.AddressMapping'),
        ], LoginFormData::class));
    }
}
