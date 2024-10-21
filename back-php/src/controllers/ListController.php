<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/ListService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$url = explode('/', $_SERVER['REQUEST_URI']);
$id_usuario = isset($url[3]) ? (int)$url[3] : 0;
$id_lista = isset($url[5]) ? (int)$url[5] : 0;


if (validatorMethodServer('POST')) {
    if (isset($_POST['nome_lista']) && isset($_POST['descricao']) && isset($_POST['id_tipo_lista'])) {
        try {
            $response = ListService::createList(
                $id_usuario,
                $_POST['nome_lista'],
                $_POST['descricao'],
                $_POST['id_tipo_lista']
            );
            output(201, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

if (validatorMethodServer('GET') && $id_usuario) {
    try {
        $response = ListService::getAllLists($id_usuario);
        output(200, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
    }
}

if (validatorMethodServer('PUT') && $id_lista && $id_usuario) {
    parse_str(file_get_contents("php://input"), $_PUT);
    if (isset($_PUT['nome_lista']) && isset($_PUT['descricao']) && isset($_PUT['id_tipo_lista'])) {
        try {
            $response = ListService::updateList(
                $id_usuario,
                $id_lista,
                $_PUT['nome_lista'],
                $_PUT['descricao'],
                $_PUT['id_tipo_lista']
            );
            output(200, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

if (validatorMethodServer('DELETE') && $id_lista) {
    try {
        $response = ListService::deleteList($id_usuario, $id_lista);
        output(200, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
    }
}

output(400, ["error" => "Tipo de requisição não aceita"]);
