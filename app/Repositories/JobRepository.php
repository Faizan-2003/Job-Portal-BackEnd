<?php

namespace Repositories;

use Models\Jobs;
use PDO;
use PDOException;

class JobRepository extends Repository{

    public function getAllJobs(){
        try {
            $stmt = $this->connection->prepare("SELECT * FROM jobs");
            $stmt->execute();

            $jobs = $stmt->fetchAll(PDO::FETCH_CLASS, 'Models\Jobs');

            return $jobs;

        } catch (PDOException $e) {
            $this->handleError($e);
            return null;
        }
    }
}