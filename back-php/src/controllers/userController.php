<?php

require_once(__DIR__ . '/../services/UserService.php');
require_once(__DIR__ . '/../config/utils.php');
require_once(__DIR__ . '/../models/User.php');

header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

class UserController {

    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function handleRequest(string $method): void {
        try {
            $method = strtoupper($method);
            switch ($method) {
                case 'POST':
                    $this->handlePost();
                    break;

                case 'GET':
                    $this->handleGet();
                    break;

                default:
                    $this->output(405, ["error" => "Método não permitido"]);
                    break;
            }
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function handlePost(): void {
        $params = $this->getRequestParams(['name', 'email', 'password']);
        
        if ($params) {
            $this->createUser($params['name'], $params['email'], $params['password']);
        } else {
            $loginParams = $this->getRequestParams(['email', 'password']);
            if ($loginParams) {
                $this->loginUser($loginParams['email'], $loginParams['password']);
            } else {
                $this->output(400, ["error" => "Parâmetros ausentes"]);
            }
        }
    }

    private function handleGet(): void {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->getUserData($id);
        } else {
            $this->output(400, ["error" => "Parâmetro 'id' ausente"]);
        }
    }

    private function createUser($name, $email, $password): void {
        try {
            $user = new User($email, $password, $name);
            $response = $this->userService->saveUser($user);
            $this->output(201, $response);
        } catch (Exception $e) {
            $this->output($e->getCode(), ["error" => $e->getMessage()]);
        }
    }

    private function loginUser($email, $password): void {
        try {
            $user = new User($email, $password);
            $response = $this->userService->getUser($user);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output($e->getCode(), ["error" => $e->getMessage()]);
        }
    }

    private function getUserData($id): void {
        try {
            $response = $this->userService->getMyData($id);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output($e->getCode(), ["error" => $e->getMessage()]);
        }
    }

    private function getRequestParams(array $keys, array $inputData = null): ?array {
        $inputData = $inputData ?: ($_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST : $_GET);
        $params = [];
        foreach ($keys as $key) {
            if (empty($inputData[$key])) {
                return null;
            }
            $params[$key] = htmlspecialchars(trim($inputData[$key]));
        }
        return $params;
    }

    private function output(int $statusCode, array $response): void {
        http_response_code($statusCode);
        echo json_encode($response);
    }
}

$controller = new UserController(new UserService());
$controller->handleRequest($_SERVER['REQUEST_METHOD']);