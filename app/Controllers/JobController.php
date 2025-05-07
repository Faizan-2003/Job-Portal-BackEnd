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
}