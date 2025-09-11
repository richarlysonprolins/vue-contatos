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

$id = $data["id"];

// Usando prepared statement para evitar SQL injection
$stmt = $conn->prepare("DELETE FROM contatos WHERE id=?");
$stmt->bind_param("i", 
    $id
);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
    ]);
} else {
    echo json_encode([
        "success" => false,
        "mensagem" => $stmt->error
    ]);
}
?>