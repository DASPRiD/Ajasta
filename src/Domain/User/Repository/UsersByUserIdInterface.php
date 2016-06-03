<?php
declare(strict_types = 1);

namespace Ajasta\Domain\User\Repository;

use Ajasta\Domain\Exception\UserNotFound;
use Ajasta\Domain\User\User;
use Ajasta\Domain\User\UserId;

interface UsersByUserIdInterface
{
    public function has(UserId $userId) : bool;

    /**
     * @throws UserNotFound
     */
    public function get(UserId $userId) : User;
}
