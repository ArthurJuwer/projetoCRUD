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
        require_once "../../controllers/UserController.php";
        $userProfile = new UserProfile;
        $emailUsuario = $userProfile->getEmailLogado();

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $userProfile->obterDadosFormulario();
            $userProfile->atualizarBancoDados();
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
            <h1>Meu perfil</h1>
        </div>
        <div class="header-infos">
            <p><?=$emailUsuario?></p>
            <p>trocar perfil</p>
            <a href="../../login.php">sair</i></a>
        </div>
    </section>
    <section class="content">
        <h2>Mudar Informações</h2>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <div class="row-form">
                <label for="cargo">Cargo: </label>
                <input type="text" name="cargo" value="<?=htmlspecialchars($userProfile->dadosFormulario['position'])?>">
            </div>
            <div class="row-form">
                <label for="primeiroNome">Primeiro nome: </label>
                <input type="text" name="primeiroNome" value="<?=htmlspecialchars($userProfile->dadosFormulario['firstName'])?>">
            </div>
            <div class="row-form">
                <label for="sobrenome">Sobrenome: </label>
                <input type="text" name="sobrenome" value="<?=htmlspecialchars($userProfile->dadosFormulario['lastName'])?>">
            </div>
            <div class="row-form">
                <label for="isAdmin">Administrador do sistema: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="isAdmin" value="<?=htmlspecialchars($userProfile->dadosFormulario['user_type'])?>" disabled>
                </div>
            </div>
            <div class="row-form">
                <label for="genero">Gênero: </label>
                <select name="genero">
                    <option value="Masculino" <?= $userProfile->dadosFormulario['gender'] == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                    <option value="Feminino" <?= $userProfile->dadosFormulario['gender'] == 'Feminino' ? 'selected' : '' ?>>Feminino</option>
                    <option value="Undefined" <?= $userProfile->dadosFormulario['gender'] == 'Undefined' ? 'selected' : '' ?>>Prefiro não informar</option>
                </select>
            </div>
            <div class="row-form">
                <label for="funcionario">Funcionário: </label>
                <select name="funcionario">
                    <option value="isFuncionarioFalse" <?= $userProfile->dadosFormulario['isEmployee'] == 'isFuncionarioFalse' ? 'selected' : '' ?>>Não</option>
                    <option value="isFuncionarioTrue" <?= $userProfile->dadosFormulario['isEmployee'] == 'isFuncionarioTrue' ? 'selected' : '' ?>>Sim</option>
                </select>
            </div>
            <div class="row-form">
                <label for="supervisor">Supervisor: </label>
                <select name="supervisor">
                    <option value="nao definido" <?= $userProfile->dadosFormulario['supervisor'] == 'nao definido' ? 'selected' : '' ?>>Não Definido</option>
                    <optgroup label="Grupo 1">
                        <option value="arthur" <?= $userProfile->dadosFormulario['supervisor'] == 'arthur' ? 'selected' : '' ?>>Arthur</option>
                        <option value="rodrigo" <?= $userProfile->dadosFormulario['supervisor'] == 'rodrigo' ? 'selected' : '' ?>>Rodrigo</option>
                    </optgroup>
                    <optgroup label="Grupo 2">
                        <option value="leonardo" <?= $userProfile->dadosFormulario['supervisor'] == 'leonardo' ? 'selected' : '' ?>>Leonardo</option>
                        <option value="eduardo" <?= $userProfile->dadosFormulario['supervisor'] == 'eduardo' ? 'selected' : '' ?>>Eduardo</option>
                    </optgroup> 
                </select>
            </div>
            <div class="row-form">
                <label for="Nome">Usuário Externo? </label>
                <p><?= $userProfile->dadosFormulario['user_extern'] == '1' ? 'Externo' : 'Interno' ?></p>
            </div>
            <hr>
            <div class="row-form">
                <label for="password">Senha: </label>
                <div class="row-form-image">
                    <img src="../../assets/images/eyeOpen.png" alt="showPassword" name="imagePassword">
                    <input type="password" name="password" value="<?=htmlspecialchars($userProfile->dadosFormulario['password'])?>">
                </div>
            </div>
            <hr>
            <div class="row-form">
                <label for="endereco">Endereço: </label>
                <textarea name="endereco"><?=htmlspecialchars($userProfile->dadosFormulario['address'])?></textarea>
            </div>
            <div class="row-form">
                <label for="cep">CEP: </label>
                <input type="text" name="cep" value="<?=htmlspecialchars($userProfile->dadosFormulario['zipCode'])?>">
            </div>
            <div class="row-form">
                <label for="municipio">Município: </label>
                <input type="text" name="municipio" value="<?=htmlspecialchars($userProfile->dadosFormulario['city'])?>">
            </div>
            <div class="row-form">
                <label for="pais">País: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-earth-americas"></i>
                    <input type="text" name="pais" value="<?=htmlspecialchars($userProfile->dadosFormulario['country'])?>">
                </div>
            </div>
            <div class="row-form">
                <label for="estado">Estado: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <input type="text" name="estado" value="<?=htmlspecialchars($userProfile->dadosFormulario['state'])?>">
                </div>
            </div>
            <div class="row-form">
                <label for="celular">Celular: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-phone"></i>
                    <input type="tel" name="celular" value="<?=htmlspecialchars($userProfile->dadosFormulario['phone'])?>">
                </div>
            </div>
            <div class="row-form">
                <label for="email">Email: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-at"></i>
                    <input type="text" name="email" value="<?=htmlspecialchars($userProfile->dadosFormulario['email'])?>" disabled>
                </div>
            </div>
            <div class="end-form">
                <input type="submit" value="Atualizar">
            </div>
        </form>
    </section>
</body>
</html>