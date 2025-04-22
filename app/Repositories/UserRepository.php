<?php

namespace Repositories;

use Models\User;
use PDO;
use PDOException;

class UserRepository extends Repository {
    // public function authenticateAndGetUser($username, $password): ?user
    // {
    //     $query = "SELECT userName, userType, userEmail, userPassword FROM user WHERE userEmail = :userEmail";
    //     $params = array(
    //         ":userEmail" => $userEmail
    //     );
    //     $result = $this->ExecQueryAndGetResults($query, $params, false);
    //     if (!$this->checkIfUserExist($userEmail)) {
    //         throw new NotFoundException("This {$userEmail} username does not exist.");
    //     }
    //     if ($this->verifyPassword($password, $result["password"])) {
    //         return new user($result["userID"], $result["userName"], $result["userPassword"], $result["userEmail"], role::createFrom($result["userType"]));
    //     }
    //     return null;
    // }


public function authenticateAndGetUser($username, $password): ?User
{
    try {
        $query = "SELECT userID, userName, userType, userEmail, userPassword FROM user WHERE userEmail = :userEmail";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":userEmail", $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new \Models\Exceptions\NotFoundException("This {$username} username does not exist.");
        }

        if (password_verify($password, $result["userPassword"])) {
            return new User(
                $result["userID"],
                $result["userName"],
                $result["userType"],
                $result["userEmail"],
                $result["userPassword"]
            );
        }

        return null;
    } catch (PDOException $e) {
        error_log("Database error in authenticateAndGetUser: " . $e->getMessage());
        return null;
    }
}
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
            $stmt = $this->connection->prepare("SELECT userName, userType, 	userEmail, userPassword FROM user WHERE userEmail = :userEmail");
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