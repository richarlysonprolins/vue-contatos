<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Se for requisição OPTIONS (preflight), finaliza aqui
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

include("conexao.php");

$resultados = mysqli_query($conn, "SELECT * FROM contatos");

$contatos = [];
while($row = mysqli_fetch_array($resultados)) {
    $contatos[] = $row;
}

echo json_encode($contatos);
?>
