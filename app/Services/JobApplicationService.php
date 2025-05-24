<?php
// Service for job applications
namespace Services;

use Repositories\JobApplicationRepository;

class JobApplicationService {
    private $jobApplicationRepository;

    public function __construct() {
        $this->jobApplicationRepository = new JobApplicationRepository();
    }
    
    public function applyForJob($data) {
        return $this->jobApplicationRepository->addApplication($data);
    }

    public function getApplicationsByUser($userId) {
        return $this->jobApplicationRepository->getApplicationsByUser($userId);
    }
}
