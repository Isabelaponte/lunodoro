<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/ListService.php');
require_once(__DIR__ . '/../config/utils.php');
require_once(__DIR__ . '/../models/List.php');

header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class ListController
{
    private ListService $listService;

    public function __construct(ListService $listService)
    {
        $this->listService = $listService;
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
        $params = $this->getRequestParams(['id_user', 'name_list', 'description', 'id_type_list']);
        if ($params) {
            $this->createList($params['id_user'], $params['name_list'], $params['description'], $params['id_type_list']);
        } else {
            $this->output(400, ["error" => "Parâmetros ausentes"]);
        }
    }

    private function handleGet(): void
    {
        $id_user = $_GET['id_user'] ?? null;
        $id_list = $_GET['id_list'] ?? null;
        if($id_user && $id_list){
            $this->getList($id_user, $id_list);
        } elseif ($id_user) {
            $this->getAllLists($id_user);
        } else {
            $this->output(400, ["error" => "Parâmetros ausentes"]);
        }
    }

    private function handlePut(): void
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        $params = $this->getRequestParams(['id_user', 'id_list', 'name_list', 'description', 'id_type_list'], $_PUT);
        if ($params) {
            $this->updateList($params['id_user'], $params['name_list'], $params['description'], $params['id_type_list'], $params['id_list']);
        } else {
            $this->output(400, ["error" => "Parâmetros ausentes"]);
        }
    }

    private function handleDelete(): void
    {
        $id_user = $_GET['id_user'] ?? null;
        $id_list = $_GET['id_list'] ?? null;
        if ($id_user && $id_list) {
            $this->deleteList($id_user, $id_list);
        } else {
            $this->output(400, ["error" => "Parâmetros ausentes"]);
        }
    }

    private function createList($id_user, $name_list, $description, $id_type_list): void
    {
        try {
            $list = new Listing($name_list, $description, $id_type_list, $id_user);
            $response = $this->listService->saveList($id_user, $list);
            $this->output(201, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function getAllLists($id_user): void
    {
        try {
            $response = $this->listService->getAll($id_user);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function getList($id_user, $id_list): void
    {
        try {
            $response = $this->listService->getList($id_user, $id_list);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function updateList($id_user, $name_list, $description, $id_type_list, $id_list): void
    {
        try {
            $list = new Listing($name_list, $description, $id_type_list);
            $list->setIdList($id_list);
            $response = $this->listService->update($id_user, $list);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function deleteList($id_user, $id_list): void
    {
        try {
            $response = $this->listService->delete($id_user, $id_list);
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

$controller = new ListController(new ListService());
$controller->handleRequest($_SERVER['REQUEST_METHOD']);
