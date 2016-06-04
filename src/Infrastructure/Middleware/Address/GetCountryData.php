<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Middleware\Address;

use CommerceGuys\Addressing\Repository\AddressFormatRepositoryInterface;
use CommerceGuys\Addressing\Repository\SubdivisionRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetCountryData
{
    /**
     * @var AddressFormatRepositoryInterface
     */
    private $addressFormatRepository;

    /**
     * @var SubdivisionRepositoryInterface
     */
    private $subdivisionRepository;

    public function __construct(
        AddressFormatRepositoryInterface $addressFormatRepository,
        SubdivisionRepositoryInterface $subdivisionRepository
    ) {
        $this->addressFormatRepository = $addressFormatRepository;
        $this->subdivisionRepository = $subdivisionRepository;
    }

    public function __invoke(ServerRequestInterface $request) : ResponseInterface
    {
        $addressFormat = $this->addressFormatRepository->get($request->getAttribute('countryCode'));

        return new JsonResponse([
            'usedFields' => $addressFormat->getUsedFields(),
            'groupedFields' => $addressFormat->getGroupedFields(),
            'requiredFields' => $addressFormat->getRequiredFields(),
            'postalCodePattern' => $addressFormat->getPostalCodePattern(),
            'administrativeAreaType' => $addressFormat->getAdministrativeAreaType(),
            'localityType' => $addressFormat->getLocalityType(),
            'dependentLocalityType' => $addressFormat->getDependentLocalityType(),
            'postalCodeType' => $addressFormat->getPostalCodeType(),
            'administrativeAreaChoices' => $this->subdivisionRepository->getList($addressFormat->getCountryCode(), 0),
        ]);
    }
}
