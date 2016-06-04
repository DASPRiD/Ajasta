<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\Middleware\Address;

use Ajasta\Infrastructure\Middleware\Address\GetCountryData;
use CommerceGuys\Addressing\Repository\AddressFormatRepository;
use CommerceGuys\Addressing\Repository\SubdivisionRepository;
use Interop\Container\ContainerInterface;

class GetCountryDataFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new GetCountryData(
            new AddressFormatRepository(),
            new SubdivisionRepository()
        );
    }
}
