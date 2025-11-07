<?php

namespace App\Services;

use App\Domain\User\Data\LoginUserData;
use App\Domain\User\Data\UserData;
use App\Domain\User\Service\UserService;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\InvalidTokenException;


readonly class AuthService
{

    public function __construct(
        private JwtService $jwtService,
        private UserService $userService
    ) {

    }

    /**
     * @param LoginUserData $loginUserData
     * @return string
     * @throws InvalidCredentialsException
     */
    public function authenticate(LoginUserData $loginUserData): string
    {

        $userData = $this->userService->findByEmail($loginUserData->getEmail());

        if ($userData === null || password_verify($loginUserData->getPassword(), $userData->getPassword()) === false) {
            throw new InvalidCredentialsException();
        }

        return $this->jwtService->encode([
            'id' => $userData->getId(),
            3600 * 6
        ]);

    }

    /**
     * @param string $jwt
     * @return UserData
     * @throws InvalidTokenException
     */
    public function getUserFromJWT(string $jwt): UserData
    {
        $decoded = $this->jwtService->decode($jwt);

        if (!isset($decoded['id'])) {
            throw new InvalidTOkenException();
        }

        return $this->userService->findById($decoded['id']);
    }

}