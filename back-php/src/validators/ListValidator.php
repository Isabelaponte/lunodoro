<?php

require_once(__DIR__ . '/../models/enums/TypeList.php');
require_once(__DIR__ . '/../validators/UserValidator.php');
require_once(__DIR__ . '/../config/utils.php');

class ListValidator
{
    public static function validate($id_usuario, $nome_lista, $descricao, $id_tipo_lista)
    {
        $errors = [];

        if (isAValidID($id_usuario) === false) {
            $errors[] = "O ID do usuário deve ser um número inteiro positivo.";
        }

        if (empty($nome_lista) || !is_string($nome_lista)) {
            $errors[] = "O nome da lista deve ser uma string não vazia.";
        }

        if (!is_string($descricao) || strlen($descricao) > 255) {
            $errors[] = "A descrição deve ser uma string e ter no máximo 255 caracteres.";
        }

        $tipoListaEnum = TypeList::fromId($id_tipo_lista);
        if (!$tipoListaEnum) {
            $errors[] = "O tipo de lista fornecido é inválido.";
        }

        return $errors;
    }

    public static function isAValidIDList($id){
        (filter_var($id, FILTER_VALIDATE_INT) || $id >= 0) ? true : false;
    }
}
