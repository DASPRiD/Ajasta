<?php
namespace Ajasta\Client\Service;

use Ajasta\Client\Entity\Client;
use Doctrine\Common\Persistence\ObjectManager;

class ClientService
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @param ObjectManager    $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param Client $client
     */
    public function persist(Client $client)
    {
        $this->objectManager->persist($client);
        $this->objectManager->flush();
    }

    /**
     * @param Client $client
     */
    public function archive(Client $client)
    {
        $client->setActive(false);
        $this->persist($client);
    }

    /**
     * @param Client $client
     */
    public function activate(Client $client)
    {
        $client->setActive(true);
        $this->persist($client);
    }
}
