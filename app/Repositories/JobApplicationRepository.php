<?php
namespace Repositories;

use Models\JobApplication;
use PDO;

class JobApplicationRepository extends Repository {
    public function addApplication($data)
    {
        try {
            $stmt = $this->connection->prepare("
                INSERT INTO job_applications (userID, jobID, status, resume, applied_at)
                VALUES (:userID, :jobID, :status, :resume, NOW())
            ");
            $stmt->bindParam(":userID", $data['userID']);
            $stmt->bindParam(":jobID", $data['jobID']);
            $stmt->bindParam(":status", $data['status']);
            $stmt->bindParam(":resume", $data['resume']);
            $stmt->execute();
            return $this->connection->lastInsertId();
        } catch (\PDOException $e) {
            error_log("Database error in addApplication: " . $e->getMessage());
            return null;
        }
    }

    public function getApplicationsByUser($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM job_applications WHERE userID = :userID");
            $stmt->bindParam(":userID", $userId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Database error in getApplicationsByUser: " . $e->getMessage());
            return false;
        }
    }
}
