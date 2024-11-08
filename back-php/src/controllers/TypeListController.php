<?php

require_once(__DIR__ . '/../validators/MethodValidator.php');
require_once(__DIR__ . '/../services/TypeListService.php');
require_once(__DIR__ . '/../config/utils.php');

header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

try {
    if (validatorMethodServer('GET')) {
        if (isset($_GET['descricao'])) {
            $descricao = $_GET['descricao'];
            $response = TypeListService::findTypeList($descricao);
        } else {
            $response = TypeListService::getAllTypeList();
        }
        output(200, $response);
    } else {
        output(400, ["error" => "Tipo de requisição não aceita"]);
    }
} catch (Exception $e) {
    output($e->getCode(), ["error" => $e->getMessage()]);
}
?>
