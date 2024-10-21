<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/TaskService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if (validatorMethodServer('POST')) {
    if (isset($_POST['nome']) && isset($_POST['descricao']) && isset($_POST['dt_final']) && isset($_POST['status'])){
        try {
            $response = TaskService::createTask(
                $_POST['nome'],
                $_POST['descricao'],
                $_POST['dt_final'],
                $_POST['status']
            );
            output(201, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

if (validatorMethodServer('GET') && isset($_GET['id_usuario']) && isset($_GET['id'])) {
    try {
        $response = TaskService::getAllTasks($_GET['id_usuario'], $_GET['id']);
        output(200, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
    }
}

if (validatorMethodServer('PUT')) {
    parse_str(file_get_contents("php://input"), $_PUT);
    if (isset($_PUT['id_usuario']) && isset($_PUT['id']) && isset($_PUT['nome']) && isset($_PUT['descricao']) && isset($_PUT['dt_final']) && isset($_PUT['status'])) {
        try {
            $response = TaskService::updateTask(
                $_PUT['id'],
                $_PUT['id_usuario'],
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
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (isset($_DELETE['id_usuario']) && isset($_DELETE['id'])) {
        try {
            $response = TaskService::deleteTask($_DELETE['id_usuario'], $_DELETE['id']);
            output(200,$response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

output(400, ["error" => "Tipo de requisição não aceita"]);
