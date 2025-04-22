<?php

namespace Services;

use Firebase\JWT\JWT;
use Repositories\UserRepository;

class UserService {
    private $userRepository; 
    private $secretKey;

    public function __construct() {
        $this->userRepository = new UserRepository(); 
    }

    public function verifyAndGetUser($email, $password): ?\Models\User
    {
        return $this->userRepository->authenticateAndGetUser($email, $password);
    }

    public function registerUser($name, $email, $type, $hashedPassword) {
        return $this->userRepository->createUser($name, $email, $type, $hashedPassword);
    }
    public function getUserbyID($userID)
{
    return $this->userRepository->getUserbyID($userID);
}
}