<?php
declare(strict_types = 1);

namespace Ajasta\Infrastructure\Repository\User;

use Ajasta\Domain\User\Repository\Exception\UserNotFound;
use Ajasta\Domain\User\Repository\UsersByUsernameInterface;
use Ajasta\Domain\User\User;
use Ajasta\Domain\User\Username;
use Doctrine\Common\Persistence\ObjectRepository;

class UsersByUsername implements UsersByUsernameInterface
{
    /**
     * @var ObjectRepository
     */
    private $userRepository;

    public function __construct(ObjectRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function has(Username $username) : bool
    {
        return null !== $this->userRepository->findOneBy(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function get(Username $username) : User
    {
        $user = $this->userRepository->findOneBy(['username' => $username]);

        if (null === $user) {
            throw UserNotFound::fromUsername($username);
        }

        return $user;
    }
}
