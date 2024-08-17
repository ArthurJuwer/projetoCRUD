<!DOCTYPE html>
<html lang="pt-br">
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
    require_once '../../controllers/AdminController.php';

    $adminReadDb = new AdminReadDataBase;

    $emailLogado = $adminReadDb->getEmailLogado();
?>
<section class="left-menu">
        <nav>
            <div class="logo-left-menu">
                <h1>LOGOTIPO</h1>
                <span class="row"></span>    
            </div>
            <div class="title-left-menu">
            <i class="fa-solid fa-user"></i>
                <h3>Usuarios e Grupos</h3>
            </div>
            <h4>Usuario</h4>
            <ul> 
                <li><a href="./admin_dashboard.php">Dashboard</a></li>
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
            <h1>Dashboard</h1>
        </div>
        <div class="header-infos">
            <p><?=$emailLogado?></p>
            <p>trocar perfil</p>
            <a href="../../login.php">sair</i></a>
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
            $adminReadDb->lerBancoDados();
        ?>
    </tbody>
</table>
    </section>
</body>
</html>