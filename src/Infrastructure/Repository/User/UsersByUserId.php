<?php
declare(strict_types = 1);

namespace Ajasta\Infrastructure\Repository\User;

use Ajasta\Domain\User\Repository\Exception\UserNotFound;
use Ajasta\Domain\User\Repository\UsersByUserIdInterface;
use Ajasta\Domain\User\User;
use Ajasta\Domain\User\UserId;
use Doctrine\Common\Persistence\ObjectRepository;

class UsersByUserId implements UsersByUserIdInterface
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
    public function has(UserId $userId) : bool
    {
        return null !== $this->userRepository->findOneBy(['userId' => $userId]);
    }

    /**
     * {@inheritdoc}
     */
    public function get(UserId $userId) : User
    {
        $user = $this->userRepository->findOneBy(['userId' => $userId]);

        if (null === $user) {
            throw UserNotFound::fromUserId($userId);
        }

        return $user;
    }
}
