<?php

class UserValidator
{
    public static function validate($name, $email, $password, $dt_account_creation = null)
    {
        $errors = [];

        // Validar Nome
        if (self::isNullOrEmpty($name) || !is_string($name)) {
            $errors[] = "O nome deve ser uma string nao vazia.";
        }

        // Validar Email
        if (self::isNullOrEmpty($email) || self::isAInvalidEmail($email)) {
            $errors[] = "Campo email vazio ou invalido.";
        }

        // Validar Senha
        if (empty($password) || !self::validateMinimumPasswordLength($password)) {
            $errors[] = "A senha e obrigatoria e deve ter pelo menos 6 caracteres.";
        }

        // Validar Data de Criação da Conta
        if ($dt_account_creation !== null && !self::validateDate($dt_account_creation)) {
            $errors[] = "A data de criacao da conta deve estar no formato Y-m-d H:i:s.";
        }

        return $errors;
    }

    public static function validateLogin($email, $password)
    {
        $errors = [];

        // Validar Email
        if (self::isNullOrEmpty($email) || self::isAInvalidEmail($email)) {
            $errors[] = "Campo email vazio ou invalido.";
        }

        // Validar Senha
        if (self::isNullOrEmpty($password)) {
            $errors[] = "Campo senha obrigatorio.";
        }

        return $errors;
    }

    private static function validateDate($date)
    {
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return $d && $d->format('Y-m-d H:i:s') === $date;
    }

    private static function validateMinimumPasswordLength($password)
    {
        return (strlen($password) >= 6) ? true :  false;
    }

    private static function isNullOrEmpty($value)
    {
        return $value === null || empty($value);
    }

    private static function isAInvalidEmail($email)
    {
        return !filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
