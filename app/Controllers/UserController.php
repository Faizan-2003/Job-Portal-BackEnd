<?php

namespace Controllers;

use Controllers\AbstractController;

class UserController extends AbstractController {
    private $userService;

    public function __construct() {
        $this->userService = new \Services\UserService();
    }

    public function login() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['email']) || !isset($data['password'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'errors' => ['other' => 'Email and password are required']]);
                return;
            }

            $email = $data['email'];
            $password = $data['password'];

            $user = $this->userService->verifyAndGetUser($email, $password);

            if ($user) {
                $jwt = $this->userService->generateJWT($user);
                http_response_code(200);
                echo json_encode(['success' => true, 'token' => $jwt]);
            } else {
                http_response_code(401);
                echo json_encode(['success' => false, 'errors' => ['other' => 'Invalid email or password']]);
            }
        } catch (\Exception $e) {
            error_log("Exception in login: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'errors' => ['other' => 'An unexpected error occurred']]);
        }
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