<?php

namespace Repositories;

use Models\User;
use PDO;
use PDOException;

class UserRepository extends Repository {

    public function getUserbyID($userID) {
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

            $user = $stmt->fetchObject('Models\User');

            if (!$user) {
                error_log("No user found with email: $email");
                return null;
            }

            error_log("User found: " . print_r($user, true));
            return $user;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    public function createUser($name, $email, $type, $hashedPassword) {
        try {
            $stmt = $this->connection->prepare("
                INSERT INTO user (userName, userEmail, userType, userPassword) 
                VALUES (:name, :email, :type, :password)
            ");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                return $this->connection->lastInsertId(); // Return the ID of the newly created user
            }

            return null;
        } catch (PDOException $e) {
            error_log("Database error in createUser: " . $e->getMessage());
            return null;
        }
    }
}