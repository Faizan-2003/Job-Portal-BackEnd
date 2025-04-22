<?php

namespace Controllers;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

abstract class AbstractController
{
    protected function checkForJwt()
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            $this->respondWithError(401, 'Authorization token is missing');
            exit();
        }

        $authHeader = $headers['Authorization'];
        $token = str_replace('Bearer ', '', $authHeader);

        try {
            $decoded = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key('SHH_SECRET', 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            $this->respondWithError(401, 'Invalid or expired token');
            exit();
        }
    }

    protected function respond($data)
    {
        $this->respondWithCode(200, $data);
    }
    protected function respondWithError($httpCode, $message)
    {
        $data = array('errorMessage' => $message);
        $this->respondWithCode($httpCode, $data);
    }
    protected function respondWithCode($httpCode, $data): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpCode);
        echo json_encode($data);
    }
    protected function getSanitizedData()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        return $this->sanitize($data);
    }
    protected function sanitize($data)
    {
        if(is_object($data)){
            foreach ($data as $key => $value) {
                if(is_string($value)){
                    $data->$key = htmlspecialchars($value);
                }
            }
        }elseif (is_array($data)){
            foreach ($data as $key => $value) {
                if(is_string($value)){
                    $data[$key] = htmlspecialchars($value);
                }
            }
        }
        return $data;
    }
}