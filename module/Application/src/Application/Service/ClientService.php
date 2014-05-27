<?php
namespace Application\Service;

use Application\Entity\Client;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class ClientService
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $clientRepository;

    /**
     * @param ObjectManager    $objectManager
     * @param ObjectRepository $clientRepository
     */
    public function __construct(ObjectManager $objectManager, ObjectRepository $clientRepository)
    {
        $this->objectManager    = $objectManager;
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param  int $clientId
     * @return Client|null
     */
    public function find($clientId)
    {
        return $this->clientRepository->find($clientId);
    }

    /**
     * @return Client[]
     */
    public function findAllActive()
    {
        return $this->clientRepository->findAll();
    }

    /**
     * @param Client $client
     */
    public function persist(Client $client)
    {
        $this->objectManager->persist($client);
        $this->objectManager->flush();
    }
}