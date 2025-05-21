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
    $this->checkForJwt(); 

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
    $this->checkForJwt();

    try {
        if (
            !isset($_POST['jobTitle'], $_POST['jobDescription'], $_POST['jobSalary'], $_POST['jobLocation'], $_POST['jobCompany'])
        ) {
            $this->respondWithError(400, "Missing required fields");
            return;
        }

        $filename = null;
        if (isset($_FILES['coverImage']) && $_FILES['coverImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../Public/img/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $file = $_FILES['coverImage'];
            $filename = uniqid() . '_' . basename($file['name']);
            $targetPath = $uploadDir . $filename;

            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                $this->respondWithError(500, "Failed to upload image");
                return;
            }
        }

        $data = [
            'jobTitle' => $_POST['jobTitle'],
            'jobDescription' => $_POST['jobDescription'],
            'jobSalary' => $_POST['jobSalary'],
            'jobLocation' => $_POST['jobLocation'],
            'jobCompany' => $_POST['jobCompany'],
            'coverImage' => $filename,
            'jobApplicant' => $_POST['jobApplicant'] ?? null,
            'jobPostedDate' => $_POST['jobPostedDate'] ?? date('Y-m-d H:i:s')
        ];

        $jobID = $this->jobService->addJob($data);

        if ($jobID) {
            $this->respond(['success' => true, 'jobID' => $jobID, 'coverImage' => $filename]);
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
        $isJson = strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false;
        if ($isJson) {
            $data = json_decode(file_get_contents('php://input'), true);
            $filename = $data['coverImage'] ?? null;
        } else {
            $data = $_POST;
            $filename = $data['coverImage'] ?? null;
            if (isset($_FILES['coverImage']) && $_FILES['coverImage']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../Public/img/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $file = $_FILES['coverImage'];
                $filename = uniqid() . '_' . basename($file['name']);
                $targetPath = $uploadDir . $filename;
                if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $this->respondWithError(500, "Failed to upload image");
                    return;
                }
            }
        }

        $required = ['jobTitle', 'jobDescription', 'jobCompany', 'jobLocation'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                $this->respondWithError(400, "Missing required field: $field");
                return;
            }
        }

        $updateData = [
            'jobTitle' => $data['jobTitle'],
            'jobDescription' => $data['jobDescription'],
            'jobSalary' => $data['jobSalary'] ?? null,
            'jobLocation' => $data['jobLocation'],
            'jobCompany' => $data['jobCompany'],
            'coverImage' => $filename 
        ];

        $updated = $this->jobService->editJob($id, $updateData);

        if ($updated) {
            $this->respond(['success' => true, 'message' => "Job updated successfully", 'coverImage' => $filename]);
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
    $this->checkForJwt(); 

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