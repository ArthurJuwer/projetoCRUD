<?php 

function conectar(){
    $localServer = 'localhost';
    $usuarioServer = 'root';
    $senhaServer = '';
    $bancoDados = 'usuarios_cadastrados';

    try {
        $pdo = new PDO("mysql:host=$localServer;dbname=$bancoDados", $usuarioServer,$senhaServer);
        $pdo->exec("SET CHARACTER SET utf8");
    } catch (\Throwable $th) {
        return $th;
        die;
    }
    return $pdo;
}

?>