<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Se for requisição OPTIONS (preflight), finaliza aqui
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

include("conexao.php");

$id        = $data["id"];
$nome       = $data["nome"] ?? null;
$email      = $data["email"] ?? null;
$telefone   = $data["telefone"] ?? null;
$cep        = $data["cep"] ?? null;
$logradouro = $data["logradouro"] ?? null;
$numero     = $data["numero"] ?? null;
$bairro     = $data["bairro"] ?? null;
$cidade     = $data["cidade"] ?? null;
$estado     = $data["estado"] ?? null;

// Usando prepared statement para evitar SQL injection
$stmt = $conn->prepare("UPDATE contatos SET nome=?, email=?, telefone=?, cep=?, logradouro=?, numero=?, bairro=?, cidade=?, estado=? WHERE id=?");

$stmt->bind_param("sssssssssi", 
    $nome, $email, $telefone, $cep, $logradouro, $numero, $bairro, $cidade, $estado, $id
);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "ok",
    ]);
} else {
    echo json_encode([
        "status" => "erro",
        "mensagem" => $stmt->error
    ]);
}
?>