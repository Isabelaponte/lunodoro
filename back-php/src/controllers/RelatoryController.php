<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/RelatoryService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class RelatoryController
{
    private RelatoryService $relatoryService;

    public function __construct(RelatoryService $relatoryService)
    {
        $this->relatoryService = $relatoryService;
    }

    public function handleRequest(string $method): void
    {
        try {
            $method = strtoupper($method);
            if ($method == 'GET') {
                $this->handleGet();
            } else
                $this->output(405, ["error" => "Método não permitido"]);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function handleGet(): void
    {
        $id_task = $_GET['id_task'] ?? null;
        $id_user = $_GET['id_user'] ?? null;

        if ($id_task && $id_user) {
            $this->getTotalHoursOfFocus($id_task, $id_user);
        } else if ($id_user) {
            $this->getCompletedTasksByTypeListInLast7Days($id_user);
        } else {
            $this->output(400, ["error" => "Parâmetros ausentes"]);
        }
    }
    private function getTotalHoursOfFocus($id_task, $id_user): void
    {
        try {
            $response = $this->relatoryService->getTotalHoursOfFocus($id_task, $id_user);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }

    private function getCompletedTasksByTypeListInLast7Days($id_user): void
    {
        try {
            $response = $this->relatoryService->getCompletedTasksByTypeListInLast7Days($id_user);
            $this->output(200, $response);
        } catch (Exception $e) {
            $this->output(500, ["error" => $e->getMessage()]);
        }
    }
    private function output(int $statusCode, array $response): void
    {
        http_response_code($statusCode);
        echo json_encode($response);
    }
}

$controller = new RelatoryController(new RelatoryService());
$controller->handleRequest($_SERVER['REQUEST_METHOD']);


