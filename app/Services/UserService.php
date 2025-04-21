<?php

namespace Services;

use Firebase\JWT\JWT;
use Repositories\UserRepository;

class UserService {
    private $userRepository; // Declare the property explicitly
    private $secretKey;

    public function __construct() {
        $this->userRepository = new UserRepository(); // Correctly initialize the repository
    }

    public function verifyAndGetUser($email, $enteredPassword) {
        $user = $this->userRepository->getUserByEmail($email);

        if ($user && password_verify($enteredPassword, $user->userPassword)) { // Use userPassword
            return $user;
        }

        return null;
    }

    public function generateJWT($user) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // jwt valid for 1 hour
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name
            ]
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function getUserbyID($userID) {
        return $this->userRepository->getUserbyID($userID);
    }
}