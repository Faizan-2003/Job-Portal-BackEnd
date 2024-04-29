<?php

namespace Repositories;

use Models\User;
use PDO;
use PDOException;

class UserRepository extends Repository{

    function verifyAndGetUser($email, $enteredPassword)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM user WHERE userEmail = :userEmail");
            $stmt->bindParam(":userEmail", $email);
            $stmt->execute();

            $user = $stmt->fetchObject('Models\User');

            if (!$user) {
                return null;
            }

            if (!$this->verifyPassword($enteredPassword, $user->userPassword)) {
                return null;
            }

            return $user;

        } catch (PDOException $e) {
            $this->handleError($e);
            return null;
        }
    }

    public function getUserbyID($userID)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM user WHERE userID = :userID");
            $stmt->bindParam(":userID", $userID);
            $stmt->execute();

            $user = $stmt->fetchObject('Models\User');

            return $user;

        } catch (PDOException $e) {
            $this->handleError($e);
            return null;
        }
    }

}