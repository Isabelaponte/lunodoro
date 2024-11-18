<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/TaskService.php');
require_once(__DIR__ . '/../models/Task.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class TaskController
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function handleRequest(string $method): void
    {
        try {
            $method = strtoupper($method);
            switch ($method) {
                case 'POST':
                    $this->handlePost();
                    break;
                case 'GET':
                    $this->handleGet();
                    break;
                case 'PUT':
                    $this->handlePut();
                    break;
                case 'OPTIONS':
                    $this->output(200, ["message" => "OK"]);
                    break;
                case 'DELETE':
                    $this->handleDelete();
                    break;
                default:
                    $this->output(405, ["error" => "Método não permitido"]);
                    break;
            }
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function handlePost(): void
    {
        $params = $this->getRequestParams(['name', 'description', 'status', 'id_list']);
        if ($params) {
            $this->createTask(
                $params['name'],
                $params['description'],
                $params['status'],
                $params['id_list']
            );
        } else {
            $this->output(400, ["error" => "Parâmetros ausentes"]);
        }
    }

    private function handleGet(): void
    {
        $id_task = $_GET['id_task'] ?? null;
        $id_user = $_GET['id_user'] ?? null;
        $id_taskList = $_GET['id_taskList'] ?? null;

        if ($id_task && $id_user) {
            $this->getAllTasks($id_task , $id_user);
        } elseif($id_taskList && $id_user) {
            $this->getAllTasksByList($id_taskList, $id_user);
        }else {
            $this->output(400, ["error" => "Parâmetros ausentes"]);
        }
    }


    private function handlePut(): void
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        $params = $this->getRequestParams(['name', 'description', 'end_date', 'status', 'id_user', 'id_task'], $_PUT);
        if ($params) {
            $this->updateTask(
            $params['name'],
            $params['description'],
            $params['end_date'],
            $params['status'],
            $params['id_user'],
            $params['id-task']
        );
        } else {
            $this->output(400, ["error" => "Parâmetros ausentes"]);
        }
    }

    private function handleDelete(): void
    {
        $id_task = $_GET['id_task'] ?? null;
        $id_user = $_GET['id_user'] ?? null;

        if ($id_user && $id_task) {
            $this->deleteTask($id_task, $id_user);
        } else {
            $this->output(400, ["error" => "Parâmetros ausentes"]);
        }
    }

    private function createTask($name, $description, $status, $list_id): void
    {
        try {
            $task = new Task($name, $description, $status, $list_id);
            $response = $this->taskService->createTask($task);
            if (!is_array($response)) {
                throw new Exception("Invalid response format from TaskService::createTask");
            }
            $this->output(201, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }
    
    private function getAllTasks($id_task, $id_user): void
    {
        try {
            $response = $this->taskService->getAllTasks($id_task , $id_user);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function getAllTasksByList($id_taskList, $id_user): void
    {
        try {
            $response = $this->taskService->getAllTasksByList($id_taskList, $id_user);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }


    private function updateTask($name, $description, $status, $id_user, $id_task): void
    {
        try {
            $task = new Task($name, $description, $status);
            $task->setId($id_task);
            $response = $this->taskService->updateTask($task, $id_user);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function deleteTask($id_task, $id_user): void
    {
        try {
            $response = $this->taskService->deleteTask($id_task, $id_user);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function getRequestParams(array $keys, array $inputData = null): ?array
    {
        $inputData = $inputData ?: $_POST;
        $params = [];
        foreach ($keys as $key) {
            if (empty($inputData[$key])) {
                return null;
            }
            $params[$key] = $inputData[$key];
        }
        return $params;
    }

    private function output(int $statusCode, array $response): void
    {
        http_response_code($statusCode);
        echo json_encode($response);
    }
}

$controller = new TaskController(new TaskService());
$controller->handleRequest($_SERVER['REQUEST_METHOD']);