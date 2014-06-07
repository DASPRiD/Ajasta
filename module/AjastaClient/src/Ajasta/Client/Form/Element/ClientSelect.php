<?php
namespace Ajasta\Client\Form\Element;

use Doctrine\Common\Persistence\ObjectRepository;
use Zend\Form\Element\Select;

class ClientSelect extends Select
{
    /**
     * @var bool
     */
    protected $initialized = false;

    /**
     * @var ObjectRepository
     */
    protected $clientRepository;

    /**
     * @param ObjectRepository $clientRepository
     */
    public function __construct(ObjectRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
        parent::__construct();
    }

    public function getValueOptions()
    {
        if ($this->initialized) {
            return parent::getValueOptions();
        }

        $this->initialized = true;
        $valueOptions = [];

        foreach ($this->clientRepository->findBy(['active' => true]) as $client) {
            $valueOptions[$client->getId()] = $client->getName();
        }

        $this->setValueOptions($valueOptions);
        $this->insertSelectedClientIfRequired($this->value);

        return parent::getValueOptions();
    }

    public function setValue($value)
    {
        $this->insertSelectedClientIfRequired($value);
        return parent::setValue($value);
    }

    /**
     * Inserts the selected client if required.
     *
     * If the value options are not yet initialized, nothing is done. Else it is
     * checked if the selected client not within the generated value options. If
     * so, it is added to the list.
     *
     * The reason for this is so that an already selected client, which was
     * archived in the meantime, is still part of the select list until another
     * client is selected and stored.
     *
     * @param int $clientId
     */
    protected function insertSelectedClientIfRequired($clientId)
    {
        $clientId = (int) $clientId;

        if (!$this->initialized || $clientId === 0) {
            return;
        }

        $valueOptions = $this->getValueOptions();

        if (isset($valueOptions[$clientId])) {
            return;
        }

        $client = $this->clientRepository->find($clientId);

        if ($client === null) {
            return;
        }

        $valueOptions[$clientId] = $client->getName();
        $this->setValueOptions($valueOptions);
    }
}
