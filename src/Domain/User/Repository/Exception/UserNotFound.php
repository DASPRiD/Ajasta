<?php
declare(strict_types=1);

namespace Ajasta\Domain\User\Repository\Exception;

use Ajasta\Domain\User\UserId;
use Ajasta\Domain\User\Username;
use OutOfBoundsException;

class UserNotFound extends OutOfBoundsException implements ExceptionInterface
{
    public static function fromUserId(UserId $userId) : self
    {
        return new self(sprintf('User for user ID "%s" could not be found', (string) $userId));
    }

    public static function fromUsername(Username $username) : self
    {
        return new self(sprintf('User for username "%s" could not be found', (string) $username));
    }
}
