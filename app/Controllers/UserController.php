<?php

namespace Controllers;

class UserController{
    private $userService;
    private $jobService;

    function __construct($userService, $jobService)
    {
        $this->userService = $userService;
        $this->jobService = $jobService;
    }

    function login($email, $password)
    {
        $user = $this->userService->verifyAndGetUser($email, $password);
        if($user){
            return $user;
        }
        return null;
    }

    function register()
    {
        $user = $this->userService->registerUser();
        if ($user) {
            return $user;
        }
        return null;
    }


}