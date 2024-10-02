<?php

require_once '../../models/User.php';
require_once '../../database/Connection.php';
require_once '../../validators/UserValidator.php';
require_once '../../validators/MethodValidator.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

if (validatorMethodServer('POST')) {
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($name && $email && $password) {
        $errors = UserValidator::validate($name, $email, $password);

        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['errors' => $errors]);
            exit;
        }

        try {
            $conn = Connection::getConnection();
            $conn->beginTransaction();
            $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $password]);

            $stmt = $conn->prepare("SELECT id, nome_usuario, email, senha FROM usuario WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $conn->commit();
            if ($user) {
                http_response_code(200);
                echo json_encode([
                    'user' => [
                        'id' => $user['id'],
                        'name' => $user['nome_usuario'],
                        'email' => $user['email'],
                        'password' => $user['senha']
                    ]
                ]);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Usuário não encontrado.']);
            }
        } catch (PDOException $exception) {
            if ($exception->getCode() == 23000) {
                http_response_code(409);
                echo json_encode([
                    'error' => 'Conflito nos dados enviados'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'error' => 'Internal Server Error'
                ]);
            }
            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Dados insuficientes.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método não permitido. Utilize POST.']);
}
