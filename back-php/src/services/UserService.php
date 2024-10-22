<?php

require_once(__DIR__ . '/../validators/UserValidator.php');
require_once(__DIR__ . '/../repositories/UserRepository.php');
require_once(__DIR__ . '/../config/utils.php');

class UserService
{
    public static function getUser($email, $password)
    {
        $errors = UserValidator::validateLogin($email, $password);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $user = UserRepository::loginUser($email, $password);

        if (!$user) {
            throw new Exception("Usuário ou senha inválidos", 401);
        }

        return ["id" => $user];
    }

    public static function saveUser($name, $email, $password){

        $errors = UserValidator::validate($name, $email, $password);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = UserRepository::insertUserIntoDatabase($name, $email, $password);

        if(!$response){
            throw new Exception("Erro ao cadastrar usuario.", 500);
        }

        return ["msg" => "Usuario criado com sucesso!"];
    }

    public static function getMyData($id)
    {


        $user = UserRepository::getUserData($id);

        if (!$user) {
            throw new Exception("Usuário ou senha inválidos", 401);
        }

        return $user;
    }
}