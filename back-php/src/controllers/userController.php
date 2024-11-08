<?php

require_once(__DIR__ . '/../services/UserService.php');
require_once(__DIR__ . '/../config/utils.php');
require_once(__DIR__ . '/../models/User.php');

header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

class UserController {

    public function handleRequest(string $method): void
{
    try {
        switch (strtoupper($method)) {
            case 'POST':
                $name = $_POST['name'] ?? null;
                $email = $_POST['email'] ?? null;
                $password = $_POST['password'] ?? null;

                if ($name && $email && $password) {
                    $this->createUser($name, $email, $password);
                } elseif ($email && $password) {
                    $this->loginUser($email, $password);
                } else {
                    $this->output(400, ["error" => "Parâmetros ausentes"]);
                }
                break;

            case 'GET':
                $id = $_GET['id'] ?? null;

                if ($id) {
                    $this->getUserData($id);
                } else {
                    $this->output(400, ["error" => "Parâmetros ausentes"]);
                }
                break;

            default:
                $this->output(405, ["error" => "Método não permitido"]);
                break;
        }
    } catch (Exception $e) {
        $this->output($e->getCode(), ["error" => $e->getMessage()]);
    }
}

    private function createUser($name, $email, $password): void
    {
        try {
            $user = new User($email, $password, $name);
            $response = UserService::saveUser($user);
            $this->output(201, $response);
        } catch (Exception $e) {
            $this->output($e->getCode(), ["error" => $e->getMessage()]);
        }
    }

    private function loginUser($email, $password): void
    {
        try {
            $user = new User($email, $password);
            $response = UserService::getUser($user);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output($e->getCode(), ["error" => $e->getMessage()]);
        }
    }

    private function getUserData($id): void
    {
        try {
            $response = UserService::getMyData($id);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output($e->getCode(), ["error" => $e->getMessage()]);
        }
    }

    private function output(int $statusCode, array $response): void
    {
        http_response_code($statusCode);
        echo json_encode($response);
    }
}

$controller = new UserController();
$controller->handleRequest($_SERVER['REQUEST_METHOD']);