<?php
declare(strict_types = 1);

namespace Ajasta\Infrastructure\FormData;

final class LoginFormData
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $stayLoggedIn;

    public function __construct(string $username, string $password, bool $stayLoggedIn)
    {
        $this->username = $username;
        $this->password = $password;
        $this->stayLoggedIn = $stayLoggedIn;
    }

    public function getUsername() : string
    {
        return $this->username;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function shouldStayLoggedIn() : bool
    {
        return $this->stayLoggedIn;
    }
}
