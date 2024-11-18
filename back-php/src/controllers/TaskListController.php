<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/TaskListService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: POST, GET, DELETE");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class TaskListController
{

    private TaskListService $taskListService;

    public function __construct(TaskListService $taskListService)
    {
        $this->taskListService = $taskListService;
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
        $params = $this->getRequestParams(['id_list', 'id_task']);
        if ($params) {
            $this->createTaskList(
                $params['id_list'],
                $params['id_task']
            );
        } else {
            $this->output(400, ["error" => "Parâmetros ausentes"]);
        }
    }

    private function createTaskList($id_list, $id_task): void
    {
        try {
            $taskList = new TaskList($id_list, $id_task);
            $response = $this->taskListService->createListTask($taskList);
            $this->output(201, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function handleGet(): void
    {
        $id_task = $_GET['id_task'] ?? null;
        $id_user = $_GET['id_user'] ?? null;
        $id_list = $_GET['id_list'] ?? null;

        if ($id_list && $id_user) {
            $this->getAllTasksByList($id_list, $id_user);
        } else if ($id_task && $id_user) {
            $this->getAllListsByTask($id_task, $id_user);
        } else {
            $this->output(400, ["error" => "Parâmetros ausentes"]);
        }
    }

    private function getAllTasksByList($id_list, $id_user): void
    {
        try {
            $response = $this->taskListService->getAllTasksByList($id_list, $id_user);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function getAllListsByTask($id_task, $id_user): void
    {
        try {
            $response = $this->taskListService->getAllListsByTask($id_task, $id_user);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function handleDelete(): void
    {
        $id_list = $_GET['id_list'] ?? null;
        $id_task = $_GET['id_task'] ?? null;

        if ($id_list && $id_task) {
            $this->deleteTask($id_list, $id_task);
        } else {
            $this->output(400, ["error" => "Parâmetros ausentes"]);
        }
    }

    private function deleteTask($id_list, $id_task): void
    {
        try {
            $response = $this->taskListService->removeTaskList($id_list, $id_task);
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

$controller = new TaskListController(new TaskListService());
$controller->handleRequest($_SERVER['REQUEST_METHOD']);
