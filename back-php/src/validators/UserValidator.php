<?php
require_once(__DIR__ . '/../models/User.php');

class UserValidator
{
    public static function validate(User $user)
    {
        $errors = [];

        if (self::isNullOrEmpty($user->getUserName()) || !is_string($user->getUserName())) {
            $errors[] = "O nome deve ser uma string não vazia.";
        }

        if (self::isNullOrEmpty($user->getEmail()) || self::isAInvalidEmail($user->getEmail())) {
            $errors[] = "Campo email vazio ou inválido.";
        }

        if (empty($user->getPassword()) || !self::validateMinimumPasswordLength($user->getPassword())) {
            $errors[] = "A senha é obrigatória e deve ter pelo menos 6 caracteres.";
        }

        if (!self::isNullOrEmpty($user->getDtAccountCreation()) && !self::validateDate($user->getDtAccountCreation())) {
            $errors[] = "A data de criação da conta deve estar no formato Y-m-d H:i:s.";
        }

        return $errors;
    }

    public static function validateLogin(User $user)
    {
        $errors = [];

        if (self::isNullOrEmpty($user->getEmail()) || self::isAInvalidEmail($user->getEmail())) {
            $errors[] = "Campo email vazio ou inválido.";
        }

        if (self::isNullOrEmpty($user->getPassword())) {
            $errors[] = "Campo senha obrigatório.";
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
        return strlen($password) >= 6;
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