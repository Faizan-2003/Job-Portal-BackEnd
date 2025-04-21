<?php

namespace Controllers;

use Controllers\AbstractController;

class UserController extends AbstractController {
    private $userService;

    public function __construct() {
        $this->userService = new \Services\UserService();
    }

    public function login() {
        // Retrieve and decode JSON payload
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate input
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
            echo json_encode(['success' => true, 'token' => $jwt]);
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'errors' => ['other' => 'Invalid email or password']]);
        }
    }

    public function register() {
        $user = $this->userService->registerUser();
        if ($user) {
            return $user;
        }
        return null;
    }
}