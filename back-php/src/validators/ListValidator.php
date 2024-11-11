<?php

require_once(__DIR__ . '/../models/enums/TypeList.php');
require_once(__DIR__ . '/../validators/UserValidator.php');
require_once(__DIR__ . '/../config/utils.php');

class ListValidator
{
    public static function validate($id_user,$name_list, $description, $id_type_list)
    {
        $errors = [];

        if (isAValidID($id_user) === false) {
            $errors[] = "O ID do usuário deve ser um número inteiro positivo.";
        }

        if (empty($name_list) || !is_string($name_list)) {
            $errors[] = "O nome da lista deve ser uma string não vazia.";
        }

        if (!is_string($description) || strlen($description) > 255) {
            $errors[] = "A descrição deve ser uma string e ter no máximo 255 caracteres.";
        }

        $tipoListaEnum = TypeList::fromId($id_type_list);
        if (!$tipoListaEnum) {
            $errors[] = "O tipo de lista fornecido é inválido.";
        }

        return $errors;
    }

    public static function isAValidIDList($id){
        (filter_var($id, FILTER_VALIDATE_INT) || $id >= 0) ? true : false;
    }
}
