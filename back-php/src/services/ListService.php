<?php

require_once(__DIR__ . '/../repositories/ListRepository.php');
require_once(__DIR__ . '/../validators/ListValidator.php');
require_once(__DIR__ . '/../config/utils.php');

class ListService
{
    public static function saveList(int $id_user, Listing $list): array
    {
        $errors = ListValidator::validate($id_user, $list->getNamelist(), $list->getDescription(), $list->getID_type_list());

        if (!empty($errors)) {
            throw new InvalidArgumentException("Parâmetros inválidos: " . implode(", ", $errors));
        }

        $response = ListRepository::insertIntoListFromDatabase($id_user, $list);

        if (!$response) {
            throw new RuntimeException("Erro ao cadastrar lista.");
        }

        return [
            "status" => "success",
            "data" => self::formatListData($list)
        ];
    }

    public static function getAll(int $id_user): array
    {
        if (!isAValidID($id_user)) {
            throw new InvalidArgumentException("O ID do usuário deve ser um número inteiro positivo.");
        }
        $response = ListRepository::findAllLists($id_user);

        if (!$response) {
            throw new Exception("Não existem listas associadas a seu usuário.");
        }

        return [
            "status" => "success",
            "data" => $response
        ];
    }

    public static function update(int $id_user, Listing $list): array
    {
        $errors = self::validateIDs($id_user, $list->getIdList());

        if (!empty($errors)) {
            throw new InvalidArgumentException("Parâmetros inválidos: " . implode(", ", $errors));
        }
        $existingList = ListRepository::findListFromDatabase($id_user, $list->getIdList());

        if (!$existingList) {
            throw new Exception("Lista não encontrada.");
        }

        // Check for changes
        if (self::isListUnchanged($existingList, $list)) {
            throw new RuntimeException("Nenhuma alteração foi detectada nos dados da lista.");
        }

        // Update list in database
        $response = ListRepository::updateList($id_user, $list);

        if (!$response) {
            throw new RuntimeException("Erro ao atualizar a lista. Tente novamente mais tarde.");
        }

        return [
            "status" => "success",
            "data" => self::formatListData($list)
        ];
    }

    public static function delete(int $id_user, int $id_list): array
    {
        $errors = self::validateIDs($id_user, $id_list);

        if (!empty($errors)) {
            throw new InvalidArgumentException("Parâmetros inválidos: " . implode(", ", $errors));
        }

        $response = ListRepository::removeList($id_user, $id_list);

        if (!$response) {
            throw new RuntimeException("Erro ao remover a lista. Tente novamente mais tarde.");
        }

        return [
            "status" => "success",
            "data" => [
                "id" => $id_list
            ]
        ];
    }

    private static function validateIDs(int $id_user, int $id_list): array
    {
        $errors = [];

        if (!isAValidID($id_user)) {
            $errors[] = "O ID do usuário deve ser um número inteiro positivo.";
        }

        if (!isAValidID($id_list)) {
            $errors[] = "O ID da lista deve ser um número inteiro positivo.";
        }

        return $errors;
    }

    private static function formatListData(Listing $list): array
    {
        return [
            "id_list" => $list->getIdList(),
            "name_list" => $list->getNamelist(),
            "description" => $list->getDescription(),
            "id_type_list" => $list->getID_type_list()
        ];
    }

    private static function isListUnchanged(array $existingList, Listing $list): bool
    {
        return $existingList['nome_lista'] === $list->getNamelist() &&
               $existingList['descricao'] === $list->getDescription() &&
               $existingList['id_tipo_lista'] == $list->getID_type_list();
    }
}
