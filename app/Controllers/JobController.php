<?php

namespace Controllers;

class JobController extends AbstractController{

    private $jobService;

    function __construct($jobService)
    {
        $this->jobService = $jobService;
    }

    function getJobList()
    {
        return $this->jobService->getAllJobs();
    }
}