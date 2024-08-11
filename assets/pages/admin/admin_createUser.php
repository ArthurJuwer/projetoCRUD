<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Create User</title>
    <link rel="stylesheet" href="../../css/layout.css">
    <link rel="stylesheet" href="../../css/admin/admin_createUser.css">
    <script src="https://kit.fontawesome.com/e374ba1aa3.js" crossorigin="anonymous" defer></script>
    <script src="../../js/admin/admin_createUser.js" defer></script>
</head>
<body>
    <?php 
    ## TERMINAR O MYSQL
    session_start();

    $nomeUser = $_SESSION['nome_usuario'];
    
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
        <h1>Novo Utilizador</h1>
    </section>
    <section class="content">
        <h2>Criar novo Utilizador</h2>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="row-form">
                <label for="cargo">Cargo: </label>
                <input type="text" name="cargo">
            </div>
            <div class="row-form">
                <label for="primeiroNome">Primeiro nome: </label>
                <input type="text" name="primeiroNome" >
            </div>
            <div class="row-form">
                <label for="sobrenome">Sobrenome: </label>
                <input type="text" name="sobrenome">
            </div>
            <div class="row-form">
                <label for="isAdmin">Adminstrador do sistema: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-user"></i>
                    <select name="isAdmin">
                    <option value="isAdminFalse">Não</option>
                    <option value="isAdminTrue">Sim</option>
                </select>
                </div>
            </div>
            <div class="row-form">
                <label for="genero">Genero: </label>
                <select name="genero">
                    <option value="generoMasc">Masculino</option>
                    <option value="generoFem">Feminino</option>
                    <option value="generoUndefined">Prefiro não informar</option>
                </select>
            </div>
            <div class="row-form">
                <label for="funcionario">Funcionario: </label>
                <select name="funcionario">
                    <option value="isFuncionarioFalse">Não</option>
                    <option value="isFuncionarioTrue">Sim</option>
                </select>
            </div>
            <div class="row-form">
                <label for="supervisor">Supervisor: </label>
                <select name="supervisor">
                    <optgroup label="Grupo 1">
                        <option value="g1Name">Arthur</option>
                        <option value="g1Name">Rodrigo</option>
                    </optgroup>
                    <optgroup label="Grupo 2">
                        <option value="g2Name">Leonardo</option>
                        <option value="g2Name">Eduardo</option>
                    </optgroup> 
                </select>
            </div>
            <div class="row-form">
                <label for="Nome">Usuario Externo? </label>
                <p>Interno</p>
            </div>
            <hr>
            <div class="row-form">
                <label for="password">Senha: </label>
                <div class="row-form-image">
                    <img src="../../images/eyeOpen.png" alt="showPassword" name="imagePassword">
                    <input type="password" name="password" >
                </div>
            </div>
            <hr>
            <div class="row-form">
                <label for="endereço">Endereço: </label>
                <textarea name="endereco"></textarea >
            </div>
            <div class="row-form">
                <label for="cep">Cep: </label>
                <input type="text" name="cep" >
            </div>
            <div class="row-form">
                <label for="municipio">Municipio: </label>
                <input type="text" name="municipio" >
            </div>
            <div class="row-form">
                <label for="Nome">País: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-earth-americas"></i>
                    <input type="text" name="pais">
                </div>
            </div>
            <div class="row-form">
                <label for="Nome">Estado: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <input type="text" name="estado" >
                </div>
            </div>
            <div class="row-form">
                <label for="Nome">Celular: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-phone"></i>
                    <input type="tel" name="celular" >
                </div>
            </div>
            <div class="row-form">
                <label for="Nome">Email: </label>
                    <div class="row-form-icon">
                        <i class="fa-solid fa-at"></i>
                        <input type="text" name="pais">
                    </div>
                </div>
            </div>
            <div class="end-form">
                <input type="submit" value="Criar Usuário">
            </div>
        </form>
    </section>
</body>
</html>