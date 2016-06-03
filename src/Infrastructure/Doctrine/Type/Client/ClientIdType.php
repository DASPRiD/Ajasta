<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Doctrine\Type\Client;

use Ajasta\Domain\Invoice\ClientId;
use Ajasta\Infrastructure\Doctrine\Type\AbstractIdType;

class ClientIdType extends AbstractIdType
{
    /**
     * {@inheritdoc}
     */
    protected function getIdClassName() : string
    {
        return ClientId::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Ajasta.Client.ClientId';
    }
}
