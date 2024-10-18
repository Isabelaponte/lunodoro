<?php

require_once(__DIR__ . '/../repositories/ListRepository.php');
require_once(__DIR__ . '/../validators/ListValidator.php');
require_once(__DIR__ . '/../config/utils.php');

class ListService
{
    public static function createList($id_usuario, $nome_lista, $descricao, $id_tipo_lista)
    {
        $errors = ListValidator::validate($id_usuario, $nome_lista, $descricao, $id_tipo_lista);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = ListRepository::insertIntoListFromDatabase($id_usuario, $nome_lista, $descricao, $id_tipo_lista);

        if (!$response) {
            throw new Exception("Erro ao cadastrar lista", 500);
        }

        return [
            "message" => "Lista criada com sucesso!",
            "data" => [
                "id_usuario" => $id_usuario,
                "nome_lista" => $nome_lista,
                "descricao" => $descricao,
                "id_tipo_lista" => $id_tipo_lista
            ]
        ];
    }

    public static function getAllLists($id_usuario)
    {
        if (!isAValidID($id_usuario)) {
            output(400, ["errors" => ["O ID do usuário deve ser um número inteiro positivo."]]);
        }

        $response = ListRepository::findAllLists($id_usuario);

        if (!$response) {
            throw new Exception("Não existem listas associadas a seu usuário", 404);
        }

        return [
            "message" => "Listas encontradas com sucesso!",
            "data" => $response
        ];
    }

    public static function updateList($id_usuario, $id, $nome_lista, $descricao, $id_tipo_lista)
    {
        $errors = self::validateIDs($id_usuario, $id);
    
        if (!empty($errors)) {
            return output(400, ["errors" => $errors]);
        }
    
        $existingList = ListRepository::findListFromDatabase($id_usuario, $id);
        if (!$existingList) {
            output(404, ["error" => "Lista não encontrada"]);
        }
    
        if (
            $existingList['nome_lista'] === $nome_lista &&
            $existingList['descricao'] === $descricao &&
            $existingList['id_tipo_lista'] == $id_tipo_lista
        ) {
            output(400, ["errors" => ["Nenhuma alteração foi detectada nos dados da lista."]]);
        }
    
        $response = ListRepository::updateList($id_usuario, $id, $nome_lista, $descricao, $id_tipo_lista);
    
        if (!$response) {
            throw new Exception("Erro ao atualizar a lista. Tente novamente mais tarde.", 500);
        }
    
        return [
            "message" => "Lista atualizada com sucesso!",
            "data" => [
                "id_usuario" => $id_usuario,
                "id" => $id,
                "nome_lista" => $nome_lista,
                "descricao" => $descricao,
                "id_tipo_lista" => $id_tipo_lista
            ]
        ];
    }
    
    public static function deleteList($id_usuario, $id)
    {
        $errors = self::validateIDs($id_usuario, $id);
    
        if (!empty($errors)) {
            return output(400, ["errors" => $errors]);
        }
    
        $response = ListRepository::removeList($id_usuario, $id);
    
        if (!$response) {
            throw new Exception("Erro ao remover a lista. Tente novamente mais tarde.", 500);
        }
    
        return [
            "message" => "Lista removida com sucesso!",
            "data" => [
                "id_usuario" => $id_usuario,
                "id" => $id
            ]
        ];
    }
    
    private static function validateIDs($id_usuario, $id)
    {
        $errors = [];
    
        if (!isAValidID($id_usuario)) {
            $errors[] = "O ID do usuário deve ser um número inteiro positivo.";
        }
    
        if (!isAValidID($id)) {
            $errors[] = "O ID da lista deve ser um número inteiro positivo.";
        }
    
        return $errors;
    }    
}
