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
        $showPopUp = ['','','']; 
        require_once "../../controllers/AdminController.php";

        $adminCreateUser = new AdminCreateUser;
        $emailLogado = $adminCreateUser->getEmailLogado();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $adminCreateUser->pegarDadosFormulario();
            $adminCreateUser->criarUserNoBancoDados();
            $showPopUp = $adminCreateUser->mostrarPopup();
        }
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
        <h2>Criar Novo Usuário</h2>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="row-form">
                <label for="empresa">Empresa: </label>
                <input type="text" name="empresa" required>
            </div>
            <div class="row-form">
                <label for="cargo">Cargo: </label>
                <input type="text" name="cargo" required>
            </div>
            <div class="row-form">
                <label for="primeiroNome">Primeiro nome: </label>
                <input type="text" name="primeiroNome" required>
            </div>
            <div class="row-form">
                <label for="sobrenome">Sobrenome: </label>
                <input type="text" name="sobrenome" required>
            </div>
            <div class="row-form">
                <label for="genero">Gênero: </label>
                <select name="genero" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Undefined">Prefiro não informar</option>
                </select>
            </div>
            <div class="row-form">
                <label for="funcionario">Funcionário: </label>
                <select name="funcionario" required>
                    <option value="isFuncionarioFalse">Não</option>
                    <option value="isFuncionarioTrue">Sim</option>
                </select>
            </div>
            <div class="row-form">
                <label for="supervisor">Supervisor: </label>
                <select name="supervisor" required>
                    <option value="nao definido">Não Definido</option>
                    <optgroup label="Grupo 1">
                        <option value="arthur">Arthur</option>
                        <option value="rodrigo">Rodrigo</option>
                    </optgroup>
                    <optgroup label="Grupo 2">
                        <option value="leonardo">Leonardo</option>
                        <option value="eduardo">Eduardo</option>
                    </optgroup> 
                </select>
            </div>
            <div class="row-form">
                <label for="user_type">Tipo de Usuario: </label>
                <select name="user_type" required>
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <div class="row-form">
                <label for="email">Email: </label>
                <input type="email" name="email" required>
            </div>
            <div class="row-form">
                <label for="password">Senha: </label>
                <input type="password" name="password" required>
            </div>
            <div class="row-form">
                <label for="endereco">Endereço: </label>
                <textarea name="endereco" required></textarea>
            </div>
            <div class="row-form">
                <label for="cep">CEP: </label>
                <input type="text" name="cep" required>
            </div>
            <div class="row-form">
                <label for="municipio">Município: </label>
                <input type="text" name="municipio" required>
            </div>
            <div class="row-form">
                <label for="pais">País: </label>
                <input type="text" name="pais" required>
            </div>
            <div class="row-form">
                <label for="estado">Estado: </label>
                <input type="text" name="estado" required>
            </div>
            <div class="row-form">
                <label for="celular">Celular: </label>
                <input type="tel" name="celular" required>
            </div>
            <div class="end-form">
                <input type="submit" value="Criar Usuário">
            </div>
            <div class="alert-message <?=$showPopUp[0]?> <?=$showPopUp[1]?>" >
                <p><?=$showPopUp[2]?></p>
            </div>
        </form>
    </section>
</body>
</html>
