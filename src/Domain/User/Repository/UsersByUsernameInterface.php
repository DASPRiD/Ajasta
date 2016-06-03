<?php
declare(strict_types = 1);

namespace Ajasta\Domain\User\Repository;

use Ajasta\Domain\User\User;
use Ajasta\Domain\User\Username;

interface UsersByUsernameInterface
{
    public function has(Username $username) : bool;

    /**
     * @throws UserNotFound
     */
    public function get(Username $username) : User;
}
