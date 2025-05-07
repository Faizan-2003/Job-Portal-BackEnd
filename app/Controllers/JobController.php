<?php

namespace Controllers;

class JobController extends AbstractController {
    private $jobService;

    public function __construct()
    {
        $this->jobService = new \Services\JobService();
    }

    public function getJobList()
    {
        $this->checkForJwt();

        try {
            $jobs = $this->jobService->getAllJobs();
            $this->respond(['success' => true, 'jobs' => $jobs]);
        } catch (\Exception $e) {
            error_log("Error in getJobList: " . $e->getMessage());
            $this->respondWithError(500, "Failed to fetch job list");
        }
    }

    public function getJobsByCompany($companyId)
{
    $this->checkForJwt();

    try {
        $jobs = $this->jobService->getJobsByCompany($companyId);

        if (!empty($jobs)) {
            $this->respond(['success' => true, 'jobs' => $jobs]);
        } else {
            $this->respondWithError(404, "No jobs found for the specified company");
        }
    } catch (\Exception $e) {
        error_log("Error in getJobsByCompany: " . $e->getMessage());
        $this->respondWithError(500, "Failed to fetch jobs for the specified company");
    }
}
public function getJobByID($id)
{
    $this->checkForJwt(); // Ensure the user is authenticated

    try {
        $job = $this->jobService->getJobByID($id);

        if ($job) {
            $this->respond(['success' => true, 'job' => $job]);
        } else {
            $this->respondWithError(404, "Job not found");
        }
    } catch (\Exception $e) {
        error_log("Error in getJobByID: " . $e->getMessage());
        $this->respondWithError(500, "Failed to fetch job");
    }
}
public function addJob()
{
    $this->checkForJwt(); // Ensure the user is authenticated

    try {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['jobTitle'], $data['jobDescription'], $data['jobCompany'], $data['location'])) {
            $this->respondWithError(400, "Missing required fields");
            return;
        }

        $jobID = $this->jobService->addJob($data);

        if ($jobID) {
            $this->respond(['success' => true, 'jobID' => $jobID]);
        } else {
            $this->respondWithError(500, "Failed to add job");
        }
    } catch (\Exception $e) {
        error_log("Error in addJob: " . $e->getMessage());
        $this->respondWithError(500, "Failed to add job");
    }
}
public function editJob($id)
{
    $this->checkForJwt(); // Ensure the user is authenticated

    try {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['jobTitle'], $data['jobDescription'], $data['jobCompany'], $data['location'])) {
            $this->respondWithError(400, "Missing required fields");
            return;
        }

        $updated = $this->jobService->editJob($id, $data);

        if ($updated) {
            $this->respond(['success' => true, 'message' => "Job updated successfully"]);
        } else {
            $this->respondWithError(404, "Job not found or failed to update");
        }
    } catch (\Exception $e) {
        error_log("Error in editJob: " . $e->getMessage());
        $this->respondWithError(500, "Failed to update job");
    }
}
public function deleteJob($id)
{
    $this->checkForJwt(); // Ensure the user is authenticated

    try {
        $deleted = $this->jobService->deleteJob($id);

        if ($deleted) {
            $this->respond(['success' => true, 'message' => "Job deleted successfully"]);
        } else {
            $this->respondWithError(404, "Job not found or failed to delete");
        }
    } catch (\Exception $e) {
        error_log("Error in deleteJob: " . $e->getMessage());
        $this->respondWithError(500, "Failed to delete job");
    }
}
}