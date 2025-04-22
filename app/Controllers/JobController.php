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
}