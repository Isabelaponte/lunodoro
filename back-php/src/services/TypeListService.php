<?php

require_once(__DIR__ . '/../validators/TypeListValidator.php');
require_once(__DIR__ . '/../repositories/TypeListRepository.php');

class TypeListService
{

    public static function getAllTypeList()
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

    public static function findTypeList($descricao)
    {
        $errors = TypeListValidator::validate($descricao);

        if(!empty($errors)){
            output(400, ["errors" => $errors]);
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
