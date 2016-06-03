<?php
declare(strict_types=1);

namespace Ajasta\Domain\User;

use Ajasta\Domain\EmailAddress;

class User
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var Username
     */
    private $username;

    /**
     * @var PasswordHash
     */
    private $passwordHash;

    /**
     * @var EmailAddress
     */
    private $emailAddress;

    private function __construct()
    {
        $this->userId = UserId::newId();
    }

    public static function create(Username $username, EmailAddress $emailAddress, PasswordHash $passwordHash) : self
    {
        $user = new self();
        $user->username = $username;
        $user->emailAddress = $emailAddress;
        $user->passwordHash = $passwordHash;

        return $user;
    }

    public function getUserId() : UserId
    {
        return $this->userId;
    }

    public function getUsername() : Username
    {
        return $this->username;
    }

    public function getEmailAddress() : EmailAddress
    {
        return $this->emailAddress;
    }

    public function verifyPassword($password) : bool
    {
        return $this->passwordHash->verify($password);
    }
}
