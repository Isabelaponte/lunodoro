<?php

require_once(__DIR__ . '/../database/Connection.php');

class UserRepository
{
    public static function findUserFromDatabase($email, $password)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT nome_usuario, email FROM usuario WHERE email = ? AND senha = ?");
            $stmt->execute([$email, $password]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados", 500);
        }
    }

    public static function insertUserIntoDatabase($name, $email, $password)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $password]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new Exception("Usuario com email ja cadastrado no sistema", 409);
            }
            throw new Exception("Erro ao cadastrar usuario", 500);
        }
    }
}