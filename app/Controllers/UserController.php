<?php

namespace Controllers;

use Controllers\AbstractController;

class UserController extends AbstractController {
    private $userService;

    public function __construct() {
        $this->userService = new \Services\UserService();
    }

    public function login()
    {
        $credentials = $this->getSanitizedData();
        try {
            $user = $this->userService->verifyAndGetUser($credentials->email, $credentials->password);
        } catch (\Models\Exceptions\NotFoundException $e) {
            $this->respondWithError(401, $e->getMessage());
            return;
        }
        if (empty($user)) {
            $this->respondWithError(401, "Invalid Password Try Again");
            return;
        }
    
        // Generate JWT token
        $token = $this->generateJWT($user);
    
        // Prepare response payload
        $response = [
            'success' => true,
            'token' => $token,
            'userEmail' => $user->userName,
            'userType' => $user->userType
        ];
    
        // Respond with the payload
        $this->respond($response);
    }

    public function generateJWT($user)
    {
        $secret_key = "SHH_SECRET";
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => [
                'id' => $user->userID,
                'email' => $user->userEmail,
                'name' => $user->userName
            ]
        ];
    
        return \Firebase\JWT\JWT::encode($payload, $secret_key, 'HS256');
    }

    public function register() {
        try {
            // Retrieve and decode JSON payload
            $data = json_decode(file_get_contents('php://input'), true);
    
            // Validate input
            if (!isset($data['name']) || !isset($data['email']) || !isset($data['type']) || !isset($data['password'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'errors' => ['other' => 'Name, email, type, and password are required']]);
                return;
            }
    
            $name = $data['name'];
            $email = $data['email'];
            $type = $data['type'];
            $password = $data['password'];
    
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Call the service to register the user
            $user = $this->userService->registerUser($name, $email, $type, $hashedPassword);
    
            if ($user) {
                http_response_code(201); // Created
                echo json_encode(['success' => true, 'message' => 'User registered successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'errors' => ['other' => 'Failed to register user']]);
            }
        } catch (\Exception $e) {
            error_log("Exception in register: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'errors' => ['other' => 'An unexpected error occurred']]);
        }
    }
}