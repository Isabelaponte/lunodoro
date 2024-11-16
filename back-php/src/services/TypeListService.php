<?php

require_once(__DIR__ . '/../validators/TypeListValidator.php');
require_once(__DIR__ . '/../repositories/TypeListRepository.php');

class TypeListService
{
    public static function getAllTypeList(): array
    {
        try {
            $result = TypeListRepository::findAllTypeList();

            if (empty($result)) {
                throw new Exception("Nenhum tipo de lista encontrado", 404);
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public static function findTypeList(string $descricao): array
    {
        $errors = TypeListValidator::validate($descricao);
        if (!empty($errors)) {
            throw new Exception("Dados inválidos: " . implode(", ", $errors), 400);
        }

        try {
            $result = TypeListRepository::findTypeListFromDatabase($descricao);

            if (!$result) {
                throw new Exception("Tipo de lista não encontrado", 404);
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}
