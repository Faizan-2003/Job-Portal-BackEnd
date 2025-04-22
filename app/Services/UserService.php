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

        if (!$user) {
            error_log("User not found for email: $email");
            return null;
        }

        if (password_verify($enteredPassword, $user->userPassword)) {
            error_log("Password verified for user: $email");
            return $user;
        } else {
            error_log("Password verification failed for user: $email");
        }

        return null;
    }

    public function generateJWT($user) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;
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
    public function registerUser($name, $email, $type, $hashedPassword) {
        return $this->userRepository->createUser($name, $email, $type, $hashedPassword);
    }
}