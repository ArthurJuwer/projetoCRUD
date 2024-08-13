<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Profile</title>
    <link rel="stylesheet" href="../../assets/css/layout.css">
    <link rel="stylesheet" href="../../assets/css/user/user_perfil.css">
    <script src="https://kit.fontawesome.com/e374ba1aa3.js" crossorigin="anonymous" defer></script>
    <script src="../../assets/js/user/user_perfil.js" defer></script>
</head>
<body>
    <?php 
    session_start();
    include '../../assets/php/conexao.php';

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obtém os dados do formulário e escapa as strings para prevenir SQL Injection
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

        $emailUser = $_SESSION['nome_usuario'];

        // Atualiza os dados do usuário no banco de dados
        $sql = "UPDATE `lista_usuarios` SET
            `position` = '$cargo',
            `firstName` = '$primeiroNome',
            `lastName` = '$sobrenome',
            `gender` = '$genero',
            `isEmployee` = '$funcionario',
            `supervisor` = '$supervisor',
            `password` = '$password',
            `address` = '$endereco',
            `zipCode` = '$cep',
            `city` = '$municipio',
            `country` = '$pais',
            `state` = '$estado',
            `phone` = '$celular'
            WHERE `email` = '$emailUser'";

        if (mysqli_query($conn, $sql)) {
            echo "<p>Dados atualizados com sucesso!</p>";
        } else {
            echo "<p>Erro: " . mysqli_error($conn) . "</p>";
        }
    }

    // Recupera os dados do usuário
    $emailUser = $_SESSION['nome_usuario'];
    $sql = "SELECT * FROM lista_usuarios WHERE email = '$emailUser'";
    $dados = mysqli_query($conn, $sql);
    $linha = mysqli_fetch_assoc($dados);

    $preencherInformacoesPrimeiroNome = $linha['firstName'] ?? '';
    $preencherInformacoesSobrenome = $linha['lastName'] ?? '';
    $preencherInformacoesPosition = $linha['position'] ?? '';
    $preencherInformacoesUser = $linha['user_type'] ?? '';
    $preencherInformacoesGenero = $linha['gender'] ?? '';
    $preencherInformacoesIsFuncionario = $linha['isEmployee'] ?? '';
    $preencherInformacoesSupervisor = $linha['supervisor'] ?? '';
    $preencherInformacoesUsuarioExterno = $linha['user_extern'] ?? '';
    $preencherInformacoesPass = $linha['password'] ?? '';
    $preencherInformacoesEndereco = $linha['address'] ?? '';
    $preencherInformacoesCep = $linha['zipCode'] ?? '';
    $preencherInformacoesMunicipio = $linha['city'] ?? '';
    $preencherInformacoesPais = $linha['country'] ?? '';
    $preencherInformacoesEstado = $linha['state'] ?? '';
    $preencherInformacoesCelular = $linha['phone'] ?? '';
    $preencherInformacoesEmail = $linha['email'] ?? '';
    ?>
    <section class="left-menu">
        <nav>
            <div class="title-left-menu">
                <i class="fa-solid fa-user"></i>
                <h3>Usuarios e Grupos</h3>
            </div>
            <h4>Usuario</h4>
            <ul> 
                <li><a href="./user_dashboard.php">Inicio</a></li>
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
            <h1>Meu perfil</h1>
        </div>
        <div class="header-icons">
            <a href="../../login.php"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
    </section>
    <section class="content">
        <h2>Mudar Informações</h2>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <div class="row-form">
                <label for="cargo">Cargo: </label>
                <input type="text" name="cargo" value="<?=$preencherInformacoesPosition?>">
            </div>
            <div class="row-form">
                <label for="primeiroNome">Primeiro nome: </label>
                <input type="text" name="primeiroNome" value="<?=$preencherInformacoesPrimeiroNome?>">
            </div>
            <div class="row-form">
                <label for="sobrenome">Sobrenome: </label>
                <input type="text" name="sobrenome" value="<?=$preencherInformacoesSobrenome?>">
            </div>
            <div class="row-form">
                <label for="isAdmin">Administrador do sistema: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="isAdmin" value="<?=$preencherInformacoesUser?>" disabled>
                </div>
            </div>
            <div class="row-form">
                <label for="genero">Gênero: </label>
                <select name="genero">
                    <option value="Masculino" <?= ($preencherInformacoesGenero == 'Masculino') ? 'selected' : '' ?>>Masculino</option>
                    <option value="Feminino" <?= ($preencherInformacoesGenero == 'Feminino') ? 'selected' : '' ?>>Feminino</option>
                    <option value="Undefined" <?= ($preencherInformacoesGenero == 'generoUndefined') ? 'selected' : '' ?>>Prefiro não informar</option>
                </select>
            </div>
            <div class="row-form">
                <label for="funcionario">Funcionário: </label>
                <select name="funcionario">
                    <option value="isFuncionarioFalse" <?= ($preencherInformacoesIsFuncionario == 'isFuncionarioFalse') ? 'selected' : '' ?>>Não</option>
                    <option value="isFuncionarioTrue" <?= ($preencherInformacoesIsFuncionario == 'isFuncionarioTrue') ? 'selected' : '' ?>>Sim</option>
                </select>
            </div>
            <div class="row-form">
                <label for="supervisor">Supervisor: </label>
                <select name="supervisor">
                <option value="nao definido" <?=($supervisor == 'nao definido') ? 'selected': '' ?>>Não Definido</option>
                    <optgroup label="Grupo 1">
                        <option value="arthur" <?= ($preencherInformacoesSupervisor == 'arthur') ? 'selected' : '' ?>>Arthur</option>
                        <option value="rodrigo" <?= ($preencherInformacoesSupervisor == 'rodrigo') ? 'selected' : '' ?>>Rodrigo</option>
                    </optgroup>
                    <optgroup label="Grupo 2">
                        <option value="leonardo" <?= ($preencherInformacoesSupervisor == 'leonardo') ? 'selected' : '' ?>>Leonardo</option>
                        <option value="eduardo" <?= ($preencherInformacoesSupervisor == 'eduardo') ? 'selected' : '' ?>>Eduardo</option>
                    </optgroup> 
                </select>
            </div>
            <div class="row-form">
                <label for="Nome">Usuário Externo? </label>
                <p>Interno</p>
            </div>
            <hr>
            <div class="row-form">
                <label for="password">Senha: </label>
                <div class="row-form-image">
                    <img src="../../assets/images/eyeOpen.png" alt="showPassword" name="imagePassword">
                    <input type="password" name="password" value="<?=$preencherInformacoesPass?>">
                </div>
            </div>
            <hr>
            <div class="row-form">
                <label for="endereco">Endereço: </label>
                <textarea name="endereco"><?=$preencherInformacoesEndereco?></textarea>
            </div>
            <div class="row-form">
                <label for="cep">CEP: </label>
                <input type="text" name="cep" value="<?=$preencherInformacoesCep?>">
            </div>
            <div class="row-form">
                <label for="municipio">Município: </label>
                <input type="text" name="municipio" value="<?=$preencherInformacoesMunicipio?>">
            </div>
            <div class="row-form">
                <label for="pais">País: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-earth-americas"></i>
                    <input type="text" name="pais" value="<?=$preencherInformacoesPais?>">
                </div>
            </div>
            <div class="row-form">
                <label for="estado">Estado: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <input type="text" name="estado" value="<?=$preencherInformacoesEstado?>">
                </div>
            </div>
            <div class="row-form">
                <label for="celular">Celular: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-phone"></i>
                    <input type="tel" name="celular" value="<?=$preencherInformacoesCelular?>">
                </div>
            </div>
            <div class="row-form">
                <label for="email">Email: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-at"></i>
                    <input type="text" name="email" value="<?=$preencherInformacoesEmail?>" disabled>
                </div>
            </div>
            <div class="end-form">
                <input type="submit" value="Atualizar">
            </div>
        </form>
    </section>
</body>
</html>
