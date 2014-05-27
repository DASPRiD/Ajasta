<?php
namespace Application\Validator;

use RuntimeException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AddressFieldValidatorFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    /**
     * @var array
     */
    protected $options = [];

    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return AddressFieldValidator
     */
    public function createService(ServiceLocatorInterface $validatorManager)
    {
        if (!isset($this->options['field'])) {
            throw new RuntimeException('Missing option "field"');
        }

        return new AddressFieldValidator(
            $validatorManager->getServiceLocator()->get('Application\Service\AddressService'),
            $this->options['field']
        );
    }
}
