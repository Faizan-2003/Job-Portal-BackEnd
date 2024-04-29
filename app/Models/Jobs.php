<?php

class Jobs
{
    private int $jobID;
    private string $jobTitle;
    private string $jobDescription;
    private int $jobSalary;
    private string $jobLocation;
    private string $jobCompany;
    private string $jobApplicant;
    private string $jobPostedDate;

    public function __construct(int $jobID, string $jobTitle, string $jobDescription, int $jobSalary, string $jobLocation, string $jobCompany, string $jobApplicant, string $jobPostedDate)
    {
        $this->jobID = $jobID;
        $this->jobTitle = $jobTitle;
        $this->jobDescription = $jobDescription;
        $this->jobSalary = $jobSalary;
        $this->jobLocation = $jobLocation;
        $this->jobCompany = $jobCompany;
        $this->jobApplicant = $jobApplicant;
        $this->jobPostedDate = $jobPostedDate;
    }

    public function getJobID(): int
    {
        return $this->jobID;
    }

    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    public function getJobDescription(): string
    {
        return $this->jobDescription;
    }

    public function getJobSalary(): int
    {
        return $this->jobSalary;
    }

    public function getJobLocation(): string
    {
        return $this->jobLocation;
    }

    public function getJobCompany(): string
    {
        return $this->jobCompany;
    }

    public function getJobApplicant(): string
    {
        return $this->jobApplicant;
    }


    public function getJobPostedDate(): string
    {
        return $this->jobPostedDate;
    }

    public function setJobID(int $jobID): void
    {
        $this->jobID = $jobID;
    }

    public function setJobTitle(string $jobTitle): void
    {
        $this->jobTitle = $jobTitle;
    }

    public function setJobDescription(string $jobDescription): void
    {
        $this->jobDescription = $jobDescription;
    }

    public function setJobSalary(int $jobSalary): void
    {
        $this->jobSalary = $jobSalary;
    }

    public function setJobLocation(string $jobLocation): void
    {
        $this->jobLocation = $jobLocation;
    }

    public function setJobCompany(string $jobCompany): void
    {
        $this->jobCompany = $jobCompany;
    }

    public function setJobApplicant(string $jobApplicant): void
    {
        $this->jobApplicant = $jobApplicant;
    }

    public function setJobPostedDate(string $jobPostedDate): void
    {
        $this->jobPostedDate = $jobPostedDate;
    }

}