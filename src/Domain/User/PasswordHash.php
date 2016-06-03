<?php
declare(strict_types = 1);

namespace Ajasta\Domain\User;

use Ajasta\Domain\User\Exception\InvalidPasswordHash;

final class PasswordHash
{
    /**
     * @var string
     */
    private $hash;

    private function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    public static function fromPassword($password) : self
    {
        return new self(password_hash($password, PASSWORD_BCRYPT));
    }

    public static function fromHash($hash) : self
    {
        if (!preg_match('(^
            \$2[ayb]
            \$\d+
            \$[./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789]{53}
        $)x', $hash)) {
            throw InvalidPasswordHash::fromInvalidPasswordHash($hash);
        }

        return new self($hash);
    }

    public function verify($password) : bool
    {
        return password_verify($password, $this->hash);
    }

    public function __toString() : string
    {
        return $this->hash;
    }
}
