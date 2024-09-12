<?php

class UserValidator
{
    public static function validate($name, $email, $password, $dt_account_creation = null)
    {
        $errors = [];

        // Validar Nome
        if (empty($name) || !is_string($name)) {
            $errors[] = "O nome deve ser uma string não vazia.";
        }

        // Validar Email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Formato de email inválido.";
        }

        // Validar Senha
        if (empty($password)) {
            $errors[] = "A senha é obrigatória.";
        }

        // Validar Data de Criação da Conta
        if ($dt_account_creation !== null && !self::validateDate($dt_account_creation)) {
            $errors[] = "A data de criação da conta deve estar no formato Y-m-d H:i:s.";
        }

        return $errors;
    }

    private static function validateDate($date)
    {
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return $d && $d->format('Y-m-d H:i:s') === $date;
    }
}
