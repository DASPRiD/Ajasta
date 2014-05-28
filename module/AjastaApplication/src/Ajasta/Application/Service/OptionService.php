<?php
namespace Ajasta\Application\Service;

use Ajasta\Application\Entity\Option;
use Ajasta\Application\Entity\OptionType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use RuntimeException;

class OptionService
{
    /**
     * @var array
     */
    protected $defaults;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $optionRepository;

    /**
     * @param array            $defaults
     * @param ObjectManager    $objectManager
     * @param ObjectRepository $optionRepository
     */
    public function __construct(array $defaults, ObjectManager $objectManager, ObjectRepository $optionRepository)
    {
        $this->defaults         = $defaults;
        $this->objectManager    = $objectManager;
        $this->optionRepository = $optionRepository;
    }

    /**
     * @param  string $path
     * @return Option
     */
    public function getOption($path)
    {
        return $this->optionRepository->find($path) ?: $this->getDefaultOption($path);
    }

    /**
     * @param Option $option
     */
    public function setOption(Option $option)
    {
        $this->objectManager->persist($option);
        $this->objectManager->flush();
    }

    /**
     * @param  string $path
     * @return Option
     * @throws RuntimeException
     */
    protected function getDefaultOption($path)
    {
        if (!isset($this->defaults[$path])) {
            throw new RuntimeException(sprintf('Default for "%s" not found', $path));
        }

        $default = $this->defaults[$path];

        if (!is_array($default)) {
            throw new RuntimeException(sprintf('Default for "%s" is not an array', $path));
        }

        if (!isset($default['type'])) {
            throw new RuntimeException(sprintf('Default for "%s" has no type specified', $path));
        }

        if (!isset($default['value'])) {
            throw new RuntimeException(sprintf('Default for "%s" has no valuespecified', $path));
        }

        return new Option(OptionType::getByName($default['type']), $path, $default['value']);
    }
}