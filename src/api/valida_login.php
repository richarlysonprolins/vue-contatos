<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
include("conexao.php");

$email = $data["email"] ?? '';
$password = $data["password"] ?? '';

// Busca o usuário
$stmt = $conn->prepare("SELECT id, nome, email, senha FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Usuário não encontrado"]);
    exit();
}

$user = $result->fetch_assoc();

// Verifica a senha (2 métodos)
$login_ok = false;

// Método 1: Se senha está hasheada (começa com $2y$)
if (strpos($user['senha'], '$2y$') === 0) {
    $login_ok = password_verify($password, $user['senha']);
} 
// Método 2: Se senha está em texto puro
else {
    $login_ok = ($password === $user['senha']);
}

if ($login_ok) {
    echo json_encode([
        "success" => true,
        "message" => "Login realizado com sucesso",
        "user" => [
            "id" => $user['id'],
            "nome" => $user['nome'],
            "email" => $user['email']
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Senha incorreta"]);
}

$stmt->close();
$conn->close();
?>