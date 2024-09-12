<?php

class TaskValidator
{
    public static function validate($id, $name, $description, $start_date, $end_date, $status, $list_id)
    {
        $errors = [];

        if (!is_int($id) || $id <= 0) {
            $errors[] = "O ID deve ser um número inteiro positivo.";
        }

        if (empty($name) || !is_string($name)) {
            $errors[] = "O nome da tarefa deve ser uma string não vazia.";
        }

        if (!is_string($description)) {
            $errors[] = "A descrição deve ser uma string.";
        }

        if (!self::validateDate($start_date)) {
            $errors[] = "A data de início deve estar no formato Y-m-d H:i:s.";
        }

        if (!self::validateDate($end_date)) {
            $errors[] = "A data de término deve estar no formato Y-m-d H:i:s.";
        }

        $validStatuses = ['not started', 'in progress', 'completed', 'on hold'];
        if (!in_array($status, $validStatuses)) {
            $errors[] = "O status deve ser um dos seguintes: " . implode(', ', $validStatuses) . ".";
        }

        if (!is_int($list_id) || $list_id <= 0) {
            $errors[] = "O ID da lista deve ser um número inteiro positivo.";
        }

        return $errors;
    }

    private static function validateDate($date)
    {
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return $d && $d->format('Y-m-d H:i:s') === $date;
    }
}
