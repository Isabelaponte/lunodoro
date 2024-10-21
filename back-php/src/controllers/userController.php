<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/UserService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");


if (validatorMethodServer('POST')) {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
        try {
            $response = UserService::saveUser(
                $_POST["name"],
                $_POST["email"],
                $_POST["password"]
            );
            output(201, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } 
    elseif (isset($_POST['email']) && isset($_POST['password']) && !isset($_POST['name'])) {
        try {
            $response = UserService::getUser(
                $_POST["email"],
                $_POST["password"]
            );
            output(200, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    } else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

if(validatorMethodServer(("GET"))){
    if(isset($_GET['id'])){
        try {
            $response = UserService::getMyData(
                $_GET["id"]
            );
            output(200, $response);
        } catch (Exception $e) {
            output($e->getCode(), ["error" => $e->getMessage()]);
        }
    }else {
        output(400, ["error" => "Parâmetros ausentes"]);
    }
}

output(400, ["error" => "Tipo de requisicao nao aceita"]);
