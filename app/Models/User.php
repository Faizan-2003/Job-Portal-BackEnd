<?php

namespace Models;

class User {
    public int $userID; 
    public string $userName;
    public string $userType;
    public string $userEmail;
    public string $userPassword;

    public function __construct(
        int $userID = 0,
        string $userName = '',
        string $userType = '',
        string $userEmail = '',
        string $userPassword = ''
    ) {
        $this->userID = $userID;
        $this->userName = $userName;
        $this->userType = $userType;
        $this->userEmail = $userEmail;
        $this->userPassword = $userPassword;
    }
}