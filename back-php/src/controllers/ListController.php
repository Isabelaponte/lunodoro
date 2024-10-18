<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/ListService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if (validatorMethodServer('POST')) {
    if (isset($_POST['id_usuario']) && isset($_POST['nome_lista']) && isset($_POST['descricao']) && isset($_POST['id_tipo_lista'])) {
        try {
            $response = ListService::createList(
                $_POST['id_usuario'],
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

if (validatorMethodServer('GET') && isset($_GET['id_usuario'])) {
    try {
        $response = ListService::getAllLists($_GET['id_usuario']);
        output(200, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
    }
}

if (validatorMethodServer('PUT')) {
    parse_str(file_get_contents("php://input"), $_PUT);
    if (isset($_PUT['id_usuario']) && isset($_PUT['id']) && isset($_PUT['nome_lista']) && isset($_PUT['descricao']) && isset($_PUT['id_tipo_lista'])) {
        try {
            $response = ListService::updateList(
                $_PUT['id_usuario'],
                $_PUT['id'],
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

if (validatorMethodServer('DELETE')) {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (isset($_DELETE['id_usuario']) && isset($_DELETE['id'])) {
        try {
            $response = ListService::deleteList($_DELETE['id_usuario'], $_DELETE['id']);
            output(200,$response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

output(400, ["error" => "Tipo de requisição não aceita"]);
