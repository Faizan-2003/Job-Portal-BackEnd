<?php
// Model for job_applications table
namespace Models;

class JobApplication {
    public $applicationId;
    public $userID;
    public $jobID;
    public $status;
    public $resume; 
    public $applied_at;

    public function __construct($data = []) {
        $this->applicationId = $data['applicationID'] ?? null;
        $this->userID = $data['userID'] ?? null;
        $this->jobID = $data['jobID'] ?? null;
        $this->status = $data['status'] ?? 'Applied';
        $this->resume = $data['resume'] ?? null; 
        $this->applied_at = $data['applied_at'] ?? date('Y-m-d H:i:s');
    }
   
    // Getters
    public function getApplicationId() { return $this->applicationId; }
    public function getUserID() { return $this->userID; }
    public function getJobID() { return $this->jobID; }
    public function getStatus() { return $this->status; }
    public function getResume() { return $this->resume; }
    public function getAppliedAt() { return $this->applied_at; }

    // Setters
    public function setApplicationId($applicationId) { $this->applicationId = $applicationId; }
    public function setUserID($userID) { $this->userID = $userID; }
    public function setJobID($jobID) { $this->jobID = $jobID; }
    public function setStatus($status) { $this->status = $status; }
    public function setResume($resume) { $this->resume = $resume; }
    public function setAppliedAt($applied_at) { $this->applied_at = $applied_at; }
}
