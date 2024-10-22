<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/TaskListService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: POST, GET, DELETE");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$url = explode('/', $_SERVER['REQUEST_URI']);
$id_usuario = isset($url[3]) ? (int)$url[3] : 0;
$id_lista = isset($url[5]) ? (int)$url[5] : 0;
$id_tarefa = isset($url[7]) ? (int)$url[7] : 0;


if (validatorMethodServer('POST')) {
    if ($id_lista && $id_tarefa){
        try {
            $response = TaskListService::createListTask(
                $id_lista,
                $id_tarefa

            );
            output(201, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

if (validatorMethodServer('GET') && $id_usuario && $id_lista) {
    try {
        $response = TaskListService::getAllTasksByList($id_lista, $id_usuario);
        output(200, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
    }
}

if (validatorMethodServer('GET') && $id_tarefa && isset($id_usuario)) {
    try {
        $response = TaskListService::getAllListsByTask($id_tarefa, $id_usuario);
        output(200, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
    }
}

if (validatorMethodServer('GET') && isset($id_usuario)){
    try {
        $response = TaskListService::getCompletedTasksByTypeListInLast7Days($id_usuario);
        output(200, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
    }
}

if (validatorMethodServer('DELETE')) {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if ($id_lista && $id_tarefa) {
        try {
            $response = TaskService::deleteTask($id_lista, $id_tarefa);
            output(200,$response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

output(400, ["error" => "Tipo de requisição não aceita"]);
