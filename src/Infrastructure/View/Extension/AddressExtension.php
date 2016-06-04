<?php
declare(strict_types = 1);

namespace Ajasta\Infrastructure\View\Extension;

use CommerceGuys\Addressing\Repository\CountryRepositoryInterface;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class AddressExtension implements ExtensionInterface
{
    /**
     * @var CountryRepositoryInterface
     */
    private $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function register(Engine $engine)
    {
        $engine->registerFunction('getAddressCountryList', [$this->countryRepository, 'getList']);
    }
}
