<?php
// Allow requests from a specific origin (frontend URL)
header("Access-Control-Allow-Origin: http://localhost:5173");

// Allow specific HTTP methods
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Allow credentials if needed
header("Access-Control-Allow-Credentials: true");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

// Apply CORS headers globally for all routes
$router->before('GET|POST|PUT|DELETE|OPTIONS', '/.*', function () {
    header("Access-Control-Allow-Origin: http://localhost:5173");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Credentials: true");
});

// Set namespace for controllers
$router->setNamespace('Controllers');

$base = '/api';

// Serve static images from /img/{filename}
$router->get('/img/(.*)', function($filename) {
    $filePath = __DIR__ . '/img/' . basename($filename);
    if (file_exists($filePath)) {
        $mimeType = mime_content_type($filePath);
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit();
    } else {
        http_response_code(404);
        echo 'File not found';
        exit();
    }
});

// Serve static resumes from /resume/{filename}
$router->get('/resume/(.*)', function($filename) {
    $filePath = __DIR__ . '/resume/' . basename($filename);
    if (file_exists($filePath)) {
        $mimeType = mime_content_type($filePath);
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit();
    } else {
        http_response_code(404);
        echo 'File not found';
        exit();
    }
});

// User Management endpoints
$router->post($base . '/register', 'UserController@register');
$router->post($base . '/login', 'UserController@login');
$router->get($base . '/jobs', 'JobController@getJobList');
$router->get($base . '/user/(\d+)', 'UserController@getUserByID');
$router->get($base . '/jobs/company/(\d+)', 'JobController@getJobsByCompany');
$router->get($base . '/job/(\d+)', 'JobController@getJobByID');
$router->post($base . '/job/add', 'JobController@addJob');
$router->post($base . '/job/edit/(\d+)', 'JobController@editJob');
$router->delete($base . '/job/delete/(\d+)', 'JobController@deleteJob');
$router->post($base . '/job/apply', 'JobApplicationController@apply');
$router->get($base . '/job/applications/user/(\d+)', 'JobApplicationController@getApplicationsByUser');

// Run the router
$router->run();
?>