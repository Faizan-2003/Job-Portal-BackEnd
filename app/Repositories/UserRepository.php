<?php

namespace Repositories;

use Models\User;
use PDO;
use PDOException;

class UserRepository extends Repository{

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
    public function getUserByEmail($email) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM user WHERE userEmail = :userEmail");
            $stmt->bindParam(":userEmail", $email);
            $stmt->execute();

            $user = $stmt->fetchObject('Models\User'); // This will now work

            if (!$user) {
                return null;
            }
            return $user;
        } catch (PDOException $e) {
            $this->handleError($e);
            return null;
        }
    }
}