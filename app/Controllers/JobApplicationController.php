<?php
namespace Controllers;

class JobApplicationController extends AbstractController {
    private $jobApplicationService;

    public function __construct() {
        $this->jobApplicationService = new \Services\JobApplicationService();
    }

    // POST /api/job/apply
    public function apply() {
        $this->checkForJwt();
        $input = $_POST;
        // Check required fields
        if (!isset($input['userID'], $input['jobID'])) {
            $this->respondWithError(400, 'Missing userID or jobID');
            return;
        }
        // Handle resume upload if present
        $resumeFilename = null;
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../Public/resume/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $file = $_FILES['resume'];
            $resumeFilename = uniqid() . '_' . basename($file['name']);
            $targetPath = $uploadDir . $resumeFilename;
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                $this->respondWithError(500, 'Failed to upload resume');
                return;
            }
        }
        $data = [
            'userID' => $input['userID'],
            'jobID' => $input['jobID'],
            'status' => $input['status'] ?? 'Applied',
            'resume' => $resumeFilename
        ];
        $applicationId = $this->jobApplicationService->applyForJob($data);
        if ($applicationId) {
            $this->respond(['success' => true, 'message' => 'Application submitted', 'applicationID' => $applicationId]);
        } else {
            $this->respondWithError(500, 'Failed to submit application');
        }
    }

    // GET /api/job/applications/user/{user_id}
    public function getApplicationsByUser($userId) {
        $this->checkForJwt();
        $applications = $this->jobApplicationService->getApplicationsByUser($userId);
        if ($applications !== false) {
            $this->respond(['success' => true, 'applications' => $applications]);
        } else {
            $this->respondWithError(500, 'Failed to fetch applications');
        }
    }
}
