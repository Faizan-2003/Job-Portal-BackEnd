<?php

namespace Services;

use Repositories\UserRepository;

class UserService{

    private $userRepository;

    function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    function verifyAndGetUser($email, $enteredPassword)
    {
        return $this->userRepository->verifyAndGetUser($email, $enteredPassword);
    }

    function getUserbyID($userID)
    {
        return $this->userRepository->getUserbyID($userID);
    }
}