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
<<<<<<< HEAD
    if ($id_lista && $id_tarefa){
=======
    if (isset($_POST['id_lista']) && isset($_POST['id_tarefa'])) {
>>>>>>> 55e43e10e61ba14c44b048da620cd686a0542dff
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

<<<<<<< HEAD
if (validatorMethodServer('GET') && $id_usuario && $id_lista) {
    try {
        $response = TaskListService::getAllTasksByList($id_lista, $id_usuario);
        output(200, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
=======
if (validatorMethodServer('GET')) {
    if (isset($_GET['id_usuario']) && isset($_GET['id_lista'])) {
        try {
            $response = TaskListService::getAllTasksByList($_GET['id_lista'], $_GET['id_usuario']);
            output(200, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
>>>>>>> 55e43e10e61ba14c44b048da620cd686a0542dff
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

<<<<<<< HEAD
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
=======
>>>>>>> 55e43e10e61ba14c44b048da620cd686a0542dff

if (validatorMethodServer('DELETE')) {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if ($id_lista && $id_tarefa) {
        try {
<<<<<<< HEAD
            $response = TaskService::deleteTask($id_lista, $id_tarefa);
            output(200,$response);
=======
            $response = TaskService::deleteTask($_DELETE['id_lista'], $_DELETE['id_tarefa']);
            output(200, $response);
>>>>>>> 55e43e10e61ba14c44b048da620cd686a0542dff
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

output(400, ["error" => "Tipo de requisição não aceita"]);
