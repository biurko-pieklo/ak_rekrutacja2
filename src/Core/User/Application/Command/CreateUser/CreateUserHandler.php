<?php

namespace App\Core\User\Application\Command\CreateUser;

use App\Common\Mailer\SMPTMailer;
use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\User;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(CreateUserCommand $command): void
    {
        $user = new User(
            $command->email,
            false,
        );

        $this->userRepository->save($user);

        $this->userRepository->flush();

        try {
            if ($this->userRepository->getByEmail($user->getEmail())) {

                $mailer = new SMPTMailer();

                $mailer->send(
                    $user->getEmail(),
                    'Utworzono konto',
                    'Zarejestrowano konto w systemie. Aktywacja konta trwa do 24h',
                );
            }
        } catch (UserNotFoundException $e) {
            echo $e->getMessage();
        }
    }
}
