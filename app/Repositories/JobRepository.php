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
}