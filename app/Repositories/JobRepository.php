<?php

namespace Repositories;

use Models\Jobs;
use PDO;
use PDOException;

class JobRepository extends Repository {
    public function getAllJobs(): array
    {
        try {
            $query = "SELECT * FROM jobs"; 
            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Database error in getAllJobs: " . $e->getMessage());
            return [];
        }
    }
    public function getJobsByCompany($companyId): array
    {
        try {
            $query = "SELECT * FROM jobs WHERE jobCompany = :companyId"; 
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":companyId", $companyId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Database error in getJobsByCompany: " . $e->getMessage());
            return [];
        }
    }
    public function getJobByID($id)
{
    try {
        $stmt = $this->connection->prepare("SELECT * FROM jobs WHERE jobID = :jobID");
        $stmt->bindParam(":jobID", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        error_log("Database error in getJobByID: " . $e->getMessage());
        return null;
    }
}
public function addJob($data)
{
    try {
        $stmt = $this->connection->prepare("
            INSERT INTO jobs (coverImage, jobTitle, jobDescription, jobSalary, jobLocation, jobCompany) 
            VALUES (:coverImage, :jobTitle, :jobDescription, :jobSalary, :jobLocation, :jobCompany)
        ");
        $stmt->bindParam(":jobTitle", $data['jobTitle']);
        $stmt->bindParam(":jobDescription", $data['jobDescription']);
        $stmt->bindParam(":jobCompany", $data['jobCompany']);
        $stmt->bindParam(":jobLocation", $data['jobLocation']);
        $stmt->bindParam(":jobSalary", $data['jobSalary']);
        $stmt->bindParam(":coverImage", $data['coverImage']);
        $stmt->execute();

        return $this->connection->lastInsertId();
    } catch (\PDOException $e) {
        error_log("Database error in addJob: " . $e->getMessage());
        return null;
    }
}
public function editJob($id, $data)
{
    try {
        $stmt = $this->connection->prepare("
            UPDATE jobs 
            SET coverImage = :coverImage, jobTitle = :jobTitle, jobDescription = :jobDescription, jobCompany = :jobCompany, jobLocation = :jobLocation, jobSalary = :jobSalary
            WHERE jobID = :jobID
        ");
        $stmt->bindParam(":coverImage", $data['coverImage']);
        $stmt->bindParam(":jobTitle", $data['jobTitle']);
        $stmt->bindParam(":jobDescription", $data['jobDescription']);
        $stmt->bindParam(":jobCompany", $data['jobCompany']);
        $stmt->bindParam(":jobLocation", $data['jobLocation']);
        $stmt->bindParam(":jobSalary", $data['jobSalary']);
        $stmt->bindParam(":jobID", $id, PDO::PARAM_INT);

        return $stmt->execute();
    } catch (\PDOException $e) {
        error_log("Database error in editJob: " . $e->getMessage());
        return false;
    }
}
public function deleteJob($id)
{
    try {
        $stmt = $this->connection->prepare("DELETE FROM jobs WHERE jobID = :jobID");
        $stmt->bindParam(":jobID", $id, PDO::PARAM_INT);

        return $stmt->execute();
    } catch (\PDOException $e) {
        error_log("Database error in deleteJob: " . $e->getMessage());
        return false;
    }
}
}