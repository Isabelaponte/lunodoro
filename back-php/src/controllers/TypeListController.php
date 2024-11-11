<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/TypeListService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

class TypeListController {
    private TypeListService $typeListService;

    public function __construct(TypeListService $typeListService) {
        $this->typeListService = $typeListService;
    }

    public function handleRequest(string $method): void {
        try {
            $method = strtoupper($method);
            switch ($method) {
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

    private function handleGet(): void {
        $descricao = $_GET['descricao'] ?? null; 

        if ($descricao) {
            $response = $this->typeListService->findTypeList($descricao);
        } else {
            $response = $this->typeListService->getAllTypeList();
        }

        $this->output(200, $response);
    }

    private function output(int $statusCode, array $response): void {
        http_response_code($statusCode);
        echo json_encode($response);
    }
}

try {
    $controller = new TypeListController(new TypeListService());
    $controller->handleRequest($_SERVER['REQUEST_METHOD']); 
} catch (Exception $e) {
    output($e->getCode(), ["error" => $e->getMessage()]);
}
