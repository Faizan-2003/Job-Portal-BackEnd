<?php

namespace Services;

use Repositories\JobRepository;

class JobService
{
    private $jobRepository;

    function __construct($jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    function getAllJobs()
    {
        return $this->jobRepository->getAllJobs();
    }
}