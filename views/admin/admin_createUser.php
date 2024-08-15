<!DOCTYPE html>
<html lang="en">
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
    session_start();

    $nomeUser = $_SESSION['email_usuario'];

    include '../../assets/php/conexao.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitizing input data
        $cargo = mysqli_real_escape_string($conn, $_POST['cargo']);
        $primeiroNome = mysqli_real_escape_string($conn, $_POST['primeiroNome']);
        $sobrenome = mysqli_real_escape_string($conn, $_POST['sobrenome']);
        $genero = mysqli_real_escape_string($conn, $_POST['genero']);
        $funcionario = mysqli_real_escape_string($conn, $_POST['funcionario']);
        $supervisor = mysqli_real_escape_string($conn, $_POST['supervisor']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $endereco = mysqli_real_escape_string($conn, $_POST['endereco']);
        $cep = mysqli_real_escape_string($conn, $_POST['cep']);
        $municipio = mysqli_real_escape_string($conn, $_POST['municipio']);
        $pais = mysqli_real_escape_string($conn, $_POST['pais']);
        $estado = mysqli_real_escape_string($conn, $_POST['estado']);
        $celular = mysqli_real_escape_string($conn, $_POST['celular']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        date_default_timezone_set('America/Sao_Paulo');
        $userTimeRegistered =   date('d/m/Y H:i:s');

        // SQL Insert Statement
        $sql = "INSERT INTO `lista_usuarios` (
            `email`,
            `position`,
            `firstName`,
            `lastName`,
            `gender`,
            `isEmployee`,
            `supervisor`,
            `password`,
            `address`,
            `zipCode`,
            `city`,
            `country`,
            `state`,
            `phone`
            `time_registered`
        ) VALUES (
            '$email',
            '$cargo',
            '$primeiroNome',
            '$sobrenome',
            '$genero',
            '$funcionario',
            '$supervisor',
            '$password',
            '$endereco',
            '$cep',
            '$municipio',
            '$pais',
            '$estado',
            '$celular'
            '$userTimeRegistered'
        )";

        if (mysqli_query($conn, $sql)) {
            echo "<p>Dados criados com sucesso!</p>";
        } else {
            echo "<p>Erro: " . mysqli_error($conn) . "</p>";
        }
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
            <p><?=$nomeUser?></p>
            <p>trocar perfil</p>
            <a href="../../login.php">sair</i></a>
        </div>
    </section>
    
    <section class="content">
        <h2>Criar Novo Usuário</h2>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
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
        </form>
    </section>
</body>
</html>
