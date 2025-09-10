<?php
include("conexao.php");

$email = $_POST["email"];
$password = $_POST["password"];

$insert_user = mysqli_query($conn,"INSERT INTO usuarios (email, senha) VALUES ('$email', '$senha')");
?>