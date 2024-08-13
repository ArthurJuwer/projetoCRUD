<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Read Database</title>
    <link rel="stylesheet" href="../../assets/css/layout.css">
    <link rel="stylesheet" href="../../assets/css/admin/admin_readDB.css">
    <script src="https://kit.fontawesome.com/e374ba1aa3.js" crossorigin="anonymous" defer></script>
</head>
<body>
    <?php 
    ## TERMINAR DE ADICIONAR AS OUTRAS SEÇÕES NO DB
    session_start();

    $nomeUser = $_SESSION['nome_usuario'];

    include '../../assets/php/conexao.php';

    $sql = 'SELECT * FROM lista_usuarios';

    $dados = mysqli_query($conn, $sql);

    ?>

    
    <section class="left-menu">
        <nav>
            <div class="title-left-menu">
            <i class="fa-solid fa-user"></i>
                <h3>Usuarios e Grupos</h3>
            </div>
            <h4>Usuario</h4>
            <ul> 
                <li><a href="./admin_createUser.php">Novo utilizador</a></li>
                <li><a href="./admin_readDB.php">Lista de usuarios</a></li>
            </ul>
            <h4>Grupos</h4>
            <ul> 
                <li>Novo Grupo</li>
                <li>Lista de grupos</li>
            </ul>
        </nav>
    </section>
    <section class="header">
        <div class="header-title">
            <h1>Lista de Usuarios</h1>
        </div>
        <div class="header-icons">
            <a href="../../login.php"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
    </section>
    <section class="content">
    <h2>Tabela de Usuarios: </h2>

<table class="custom-table">
    <thead>
        <tr>
            <th>Iniciar Sessão</th>
            <th>Sobrenome</th>
            <th>Primeiro Nome</th>
            <th>SuperVisor</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Empresa</th>
            <th>Ultimo login</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>

        <?php
        while($linha = mysqli_fetch_assoc($dados)) {
            $email = $linha['email'];
            $user_type = $linha['user_type'];
            $sobrenome = $linha['lastName'];
            $nome = $linha['firstName'];
            $user_type = $linha['user_type'];
            $supervisor = $linha['supervisor'];
            $telefone = $linha['phone'];

            echo "<tr>
                <td>$user_type</td>
                <td>$sobrenome</td>
                <td>$nome</td>
                <td>$supervisor</td>
                <td>$telefone</td>
                <td>$email</td>
                <td></td>
                <td></td>
                <td><span class='ticket'>ATIVADO</span></td>
            </tr>";
        }
        
        ?>
    </tbody>
</table>
    </section>
</body>
</html>