<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "vue_contatos";

$conn = mysqli_connect($servername,$username,$password,$database);

if($conn){
    echo "Conexão realizada com sucesso!";
}else{
	echo "Erro na conexão!";
}
