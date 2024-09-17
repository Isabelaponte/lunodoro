<?php

require_once '../../models/User.php';
require_once '../../database/Connection.php';
require_once '../../validators/UserValidator.php';
require_once '../../validators/MethodValidator.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

echo 'acessado';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
            $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $password]);

            $stmt = $conn->prepare("SELECT id, nome_usuario, email, senha FROM usuario WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
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
        } catch (Exception $exception) {
            http_response_code(503);
            echo json_encode(['error' => $exception->getMessage()]);
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
