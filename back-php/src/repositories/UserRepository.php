<?php

require_once(__DIR__ . '/../database/Connection.php');

class UserRepository
{
    public static function insertUserIntoDatabase($name, $email, $password)
    {
        try {
            $conn = Connection::getConnection();
            $conn->beginTransaction();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario,
             email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashedPassword]);
            $conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $conn->rollBack();
            if ($e->getCode() == 23000) {
                throw new Exception("Email indisponível para uso no sistema.", 409);
            }
            throw new Exception("Erro ao cadastrar usuário", 500);
        }
    }

    public static function getUserData($id)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT id, nome_usuario, email, dt_criacao_conta FROM usuario WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
    

            return $user;

        } catch (PDOException $e) {
            throw new Exception("Credenciais inválidas", 401);
        }
    }
    
    public static function loginUser($email, $password)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT id, senha FROM usuario WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
    
            if ($user && password_verify($password, $user['senha'])) {
                return $user['id'];
            }
            return false; 
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados", 500);
        }
    }
    
}
