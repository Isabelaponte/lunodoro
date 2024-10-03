<?php

session_start();

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/UserService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if (validatorMethodServer('GET')) {
    try {
        $response = UserService::getUser($_GET["email"], $_GET["password"]);
        output(200, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
    }
}

if (validatorMethodServer('POST')) {
    try {
        $response = UserService::saveUser($_POST["email"], $_POST["password"], $_POST["name"]);
        output(201, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
    }
}
output(400, ["error" => "Tipo de requisicao nao aceita"]);
