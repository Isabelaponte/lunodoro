<?php

require_once(__DIR__ . '/../models/enums/TypeList.php');

class TypeListValidator
{
    public static function validate($descricao)
    {
        $errors = [];

        if (!is_string($descricao)) {
            $errors[] = "A descrição do tipo de lista deve ser feita em apenas caracteres
            de A-Z";
        }

        if (!TypeList::tryFrom($descricao))
            $errors[] = "A descrição do tipo de lista deve ser um dos seguintes valores: 'pessoal', 'trabalho', 'estudo' ou 'outros'.";
        return $errors;
    }
}
