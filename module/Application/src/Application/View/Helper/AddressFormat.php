<?php
namespace Application\View\Helper;

use Application\Entity\Address;
use Application\Service\AddressService;
use Zend\View\Helper\AbstractHelper;

class AddressFormat extends AbstractHelper
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

    /**
     * @param  Address $address
     * @return string
     */
    public function __invoke(Address $address)
    {
        return nl2br(
            $this->getView()->escapeHtml(
                implode("\n", $this->addressService->formatAddress($address))
            )
        );
    }
}
