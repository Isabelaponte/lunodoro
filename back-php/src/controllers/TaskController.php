<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/TaskService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$url = explode('/', $_SERVER['REQUEST_URI']);
$id_usuario = isset($url[3]) ? (int)$url[3] : 0;
$id_lista = isset($url[5]) ? (int)$url[5] : 0;
$id_tarefa = isset($url[7]) ? (int)$url[7] : 0;

if (validatorMethodServer('POST')) {
    if (isset($_POST['nome']) && isset($_POST['descricao']) && isset($_POST['dt_final']) && isset($_POST['status']) && $id_lista) {
        try {
            $response = TaskService::createTask(
                $_POST['nome'],
                $_POST['descricao'],
                $_POST['dt_final'],
                $_POST['status'],
                $id_lista
            );
            output(201, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

if (validatorMethodServer('GET') && $id_tarefa && $id_usuario) {
    try {
        $response = TaskService::getAllTasks($id_tarefa, $id_usuario);
        output(200, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
    }
}

if (validatorMethodServer('PUT')) {
    parse_str(file_get_contents("php://input"), $_PUT);
    if ($id_tarefa && $id_usuario && isset($_PUT['nome']) && isset($_PUT['descricao']) && isset($_PUT['dt_final']) && isset($_PUT['status'])) {
        try {
            $response = TaskService::updateTask(
                $id_tarefa,
                $id_usuario,
                $_PUT['nome'],
                $_PUT['descricao'],
                $_PUT['dt_final'],
                $_PUT['status']
            );
            output(200, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

if (validatorMethodServer('DELETE')) {
    if ($id_tarefa) {
        try {
            $response = TaskService::deleteTask($id_tarefa, $id_usuario);
            output(200, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

output(400, ["error" => "Tipo de requisição não aceita"]);
