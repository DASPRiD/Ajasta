<?php
namespace Ajasta\Address\Controller;

use Ajasta\Address\Service\AddressService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    /**
     * @var AddressService
     */
    protected $addressService;

    /**
     * @param AddressService $addressService
     */
    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function getAddressFieldsForCountryAction()
    {
        return new JsonModel([
            'fields' => $this->addressService->getFieldsForCountry($this->params('countryCode'))
        ]);
    }
}
