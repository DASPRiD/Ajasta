<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Doctrine\Type\User;

use Ajasta\Domain\User\UserId;
use Ajasta\Infrastructure\Doctrine\Type\AbstractIdType;

class UserIdType extends AbstractIdType
{
    /**
     * {@inheritdoc}
     */
    protected function getIdClassName() : string
    {
        return UserId::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Ajasta.User.UserId';
    }
}
