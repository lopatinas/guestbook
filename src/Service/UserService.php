<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private UserRepository $repository;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserRepository $repository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->repository = $repository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function register(User $user): ?User
    {
        try {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            return $this->repository->create($user);
        } catch (Exception $e) {}

        return null;
    }
}
