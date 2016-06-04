<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\View\Extension;

use Ajasta\Infrastructure\View\Extension\AddressExtension;
use CommerceGuys\Addressing\Repository\CountryRepository;
use Interop\Container\ContainerInterface;

class AddressExtensionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AddressExtension(
            new CountryRepository()
        );
    }
}
