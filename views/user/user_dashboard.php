<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/layout.css">
    <script src="https://kit.fontawesome.com/e374ba1aa3.js" crossorigin="anonymous" defer></script>
</head>
<body>
    <?php 
    
    session_start();

    $nomeUser = $_SESSION['nome_usuario'];
    
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
                <li><a href="./user_dashboard.php">Dashboard</a></li>
                <li><a href="./user_profile.php">Meu Perfil</a></li>
            </ul>
            <h4>Grupos</h4>
            <ul> 
                <li>Meus grupos</li>
            </ul>
        </nav>
    </section>

    <section class="header">
        <div class="header-title">
            <h1>Dashboard</h1>
        </div>
        <div class="header-infos">
            <p><?=$nomeUser?></p>
            <p>trocar perfil</p>
            <a href="../../login.php">sair</i></a>
        </div>
    </section>
    <section class="content">
        <h1>Conteudo</h1>
    </section>
    
</body>
</html>