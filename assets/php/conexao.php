<?php 

    $server = 'localhost';
    $user = 'root';
    $password = '';
    $dataBase = 'usuarios_cadastrados';
    
    $conn = mysqli_connect($server, $user, $password, $dataBase);
    if($conn){
        // echo "Conectado!";
    } else {
        echo "Erro!";
    }
    

?>