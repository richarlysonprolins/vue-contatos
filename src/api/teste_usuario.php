<?php
// create_user.php
include("conexao.php");

$nome = "Usuario Teste";
$email = "teste2@email.com";
$senha = "123456";
$senha_hasheada = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $senha_hasheada);

if ($stmt->execute()) {
    echo "Usuário criado! Senha: 123456";
} else {
    echo "Erro: " . $stmt->error;
}
?>