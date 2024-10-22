<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/TaskListService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: POST, GET, DELETE");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if (validatorMethodServer('POST')) {
    if (isset($_POST['id_lista']) && isset($_POST['id_tarefa'])) {
        try {
            $response = TaskListService::createListTask(
                $_POST['id_lista'],
                $_POST['id_tarefa']
            );
            output(201, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

if (validatorMethodServer('GET')) {
    if (isset($_GET['id_usuario']) && isset($_GET['id_lista'])) {
        try {
            $response = TaskListService::getAllTasksByList($_GET['id_lista'], $_GET['id_usuario']);
            output(200, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    }
    if (isset($_GET['id_tarefa']) && isset($_GET['id_usuario'])) {
        try {
            $response = TaskListService::getAllListsByTask($_GET['id_tarefa'], $_GET['id_usuario']);
            output(200, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    }
    if (isset($_GET['id_usuario'])) {
        try {
            $response = TaskListService::getCompletedTasksByTypeListInLast7Days($_GET['id_usuario']);
            output(200, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    }
    output(400, ["error" => "Parâmetros ausentes"]);
}


if (validatorMethodServer('DELETE')) {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (isset($_DELETE['id_lista']) && isset($_DELETE['id_tarefa'])) {
        try {
            $response = TaskService::deleteTask($_DELETE['id_lista'], $_DELETE['id_tarefa']);
            output(200, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

output(400, ["error" => "Tipo de requisição não aceita"]);
