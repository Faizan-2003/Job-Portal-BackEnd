<?php

namespace Services;

use Repositories\JobRepository;


class JobService {
    private $jobRepository;

    public function __construct()
    {
        $this->jobRepository = new JobRepository();
    }

    public function getAllJobs(): array
    {
        return $this->jobRepository->getAllJobs();
    }
}