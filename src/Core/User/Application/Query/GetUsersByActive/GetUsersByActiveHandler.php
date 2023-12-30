<?php

namespace App\Core\User\Application\Query\GetUsersByActive;

use App\Core\User\Application\DTO\UserDTO;
use App\Core\User\Domain\User;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetUsersByActiveHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(GetUsersByActiveQuery $query): array
    {
        $users = $this->userRepository->getUsersWithActive(
            filter_var($query->active, FILTER_VALIDATE_BOOLEAN),
        );

        return array_map(function (User $user) {
            return new UserDTO(
                $user->getId(),
                $user->getEmail(),
                $user->isActive()
            );
        }, $users);
    }
}
