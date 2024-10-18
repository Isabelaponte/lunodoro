<?php


require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/TypeListService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if (validatorMethodServer('GET') && isset($_GET['descricao'])) {
    try {
        $descricao = $_GET['descricao'];
        $response = TypeListService::findTypeList($descricao);
        output(200, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
    }
}

if (validatorMethodServer('GET') && !isset($_GET['descricao'])) {
    try {
        $response = TypeListService::getAllTypeList();
        output(200, $response);
    } catch (Exception $e) {
        output($e->getCode(), ["error" => $e->getMessage()]);
    }
}

output(400, ["error" => "Tipo de requisicao nao aceita"]);
?>