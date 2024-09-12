<?php

class TaskListValidator
{
    public static function validate($id, $name_list, $type_list, $dt_creation, $dt_atualization, $id_user, $description)
    {
        $errors = [];

        if (!is_int($id) || $id <= 0) {
            $errors[] = "O ID deve ser um número inteiro positivo.";
        }

        if (empty($name_list) || !is_string($name_list)) {
            $errors[] = "O nome da lista deve ser uma string não vazia.";
        }

        $validTypes = ['pessoal', 'trabalho', 'estudo'];
        if (!in_array($type_list, $validTypes)) {
            $errors[] = "O tipo da lista deve ser um dos seguintes: " . implode(', ', $validTypes) . ".";
        }

        if (!self::validateDate($dt_creation)) {
            $errors[] = "A data de criação deve estar no formato Y-m-d H:i:s.";
        }
        if (!self::validateDate($dt_atualization)) {
            $errors[] = "A data de atualização deve estar no formato Y-m-d H:i:s.";
        }

        if (!is_int($id_user) || $id_user <= 0) {
            $errors[] = "O ID do usuário deve ser um número inteiro positivo.";
        }

        if (!is_string($description)) {
            $errors[] = "A descrição deve ser uma string.";
        }

        return $errors;
    }

    private static function validateDate($date)
    {
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return $d && $d->format('Y-m-d H:i:s') === $date;
    }
}
