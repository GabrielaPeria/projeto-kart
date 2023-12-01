 
<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$bancodedados = "projetokart";

$conectar = mysqli_connect($host, $usuario, $senha, $bancodedados );

if($conectar){
  echo "Conectado ao banco de dados";
}
else{
  echo "erro ao conectar";
}

?>