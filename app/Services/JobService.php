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
    public function getJobsByCompany($companyId): array
    {
        return $this->jobRepository->getJobsByCompany($companyId);
    }
    public function getJobByID($id)
{
    return $this->jobRepository->getJobByID($id);
}
public function addJob($data)
{
    return $this->jobRepository->addJob($data);
}public function editJob($id, $data)
{
    return $this->jobRepository->editJob($id, $data);
}
public function deleteJob($id)
{
    return $this->jobRepository->deleteJob($id);
}
}