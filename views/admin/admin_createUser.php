<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Create User</title>
    <link rel="stylesheet" href="../../assets/css/layout.css">
    <link rel="stylesheet" href="../../assets/css/admin/admin_createUser.css">
    <script src="https://kit.fontawesome.com/e374ba1aa3.js" crossorigin="anonymous" defer></script>
    <script src="../../assets/js/admin/admin_createUser.js" defer></script>
</head>
<body>
    <?php 
        require_once "../../controllers/AdminController.php";

        $adminCreateUser = new AdminCreateUser;
        $emailLogado = $adminCreateUser->getEmailLogado();  
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
        <div class="container-content">
            <div class="container-content-create">
            <h2>Criar Novo Usuário</h2>
                 <?=$adminCreateUser->criarFormulario()?>
            </div>
            <div class="container-content-actions">
                <h2>Ações</h2>
                <form action="" method="">
                    <button name="usuarioTeste" type="submit">Replicar Usuario Teste</button>
                    <button name="usuarioAnterior" type="submit">Replicar Usuario Anterior</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
