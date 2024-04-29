<?php


class User{

    private int $userID;
    private string $username;
    public string $userType;
    private string $userEmail;
    private string $userPassword;

    public function __construct(int $userID, string $username, string $userType, string $userEmail, string $userPassword){
        $this->userID = $userID;
        $this->username = $username;
        $this->userType = $userType;
        $this->userEmail = $userEmail;
        $this->userPassword = $userPassword;
    }

    public function getUserID(): int{
        return $this->userID;
    }

    public function getUsername(): string{
        return $this->username;
    }

    public function getUserType(): string{
        return $this->userType;
    }

    public function getUserEmail(): string{
        return $this->userEmail;
    }

    public function getUserPassword(): string{
        return $this->userPassword;
    }

    public function setUserID(int $userID): void{
        $this->userID = $userID;
    }

    public function setUsername(string $username): void{
        $this->username = $username;
    }

    public function setUserType(string $userType): void{
        $this->userType = $userType;
    }

    public function setUserEmail(string $userEmail): void{
        $this->userEmail = $userEmail;
    }

    public function setUserPassword(string $userPassword): void{
        $this->userPassword = $userPassword;
    }

}