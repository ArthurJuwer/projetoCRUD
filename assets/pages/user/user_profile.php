<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Profile</title>
    <link rel="stylesheet" href="../../css/layout.css">
    <link rel="stylesheet" href="../../css/user/user_perfil.css">
    <script src="https://kit.fontawesome.com/e374ba1aa3.js" crossorigin="anonymous" defer></script>
    <script src="../../js/user/user_perfil.js"defer></script>
</head>
<body>
    <?php 
    ## AUMENTAR BANCO DE DADOS  
    ## FAZER FUNCAO CASO DE UM SUBMIT ATUALIZAR 
    ## TERMINAR O MYSQL
    session_start();

    $emailUser = $_SESSION['nome_usuario'];

    include '../../php/conexao.php';

    $sql = "SELECT * FROM lista_usuarios WHERE email LIKE '%$emailUser%'";

    $dados = mysqli_query($conn, $sql);
    $linha = mysqli_fetch_assoc($dados);


    $preencherInformacoesCargo = $linha['cargo'] ?? '';
    $preencherInformacoesPrimeiroNome = $linha['primeiroNome'] ?? '';
    $preencherInformacoesSobrenome = $linha['sobrenome'] ?? '';
    $preencherInformacoesUser = $linha['user_type'] ?? '';
    $preencherInformacoesGenero = $linha['genero'] ?? '';
    $preencherInformacoesIsFuncionario = $linha['isFuncionario'] ?? '';
    $preencherInformacoesSupervisor = $linha['supervisor'] ?? '';
    $preencherInformacoesUsuarioExterno = $linha['user_extern'] ?? '';

    $preencherInformacoesPass = $linha['password'] ?? '';

    $preencherInformacoesEndereco = $linha['endereco'] ?? '';
    $preencherInformacoesCep = $linha['cep'] ?? '';
    $preencherInformacoesMunicipio = $linha['municipio'] ?? '';
    $preencherInformacoesPais = $linha['pais'] ?? '';
    $preencherInformacoesEstado = $linha['estado'] ?? '';
    $preencherInformacoesCelular = $linha['celular'] ?? '';
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
        <h1>Meu Perfil</h1>
    </section>
    <section class="content">
        <h2>Mudar Informações</h2>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="row-form">
                <label for="cargo">Cargo: </label>
                <input type="text" name="cargo" value="<?=$preencherInformacoesCargo?>">
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
                <label for="isAdmin">Adminstrador do sistema: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="isAdmin" value="<?=$preencherInformacoesUser?>" disabled>
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
                    <input type="password" name="password" value="<?=$preencherInformacoesPass?>">
                </div>
            </div>
            <hr>
            <div class="row-form">
                <label for="endereço">Endereço: </label>
                <textarea name="endereco"></textarea value="<?=$preencherInformacoesEndereco?>">
            </div>
            <div class="row-form">
                <label for="cep">Cep: </label>
                <input type="text" name="cep" value="<?=$preencherInformacoesCep?>">
            </div>
            <div class="row-form">
                <label for="municipio">Municipio: </label>
                <input type="text" name="municipio" value="<?=$preencherInformacoesMunicipio?>">
            </div>
            <div class="row-form">
                <label for="Nome">País: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-earth-americas"></i>
                    <input type="text" name="pais" value="<?=$preencherInformacoesPais?>">
                </div>
            </div>
            <div class="row-form">
                <label for="Nome">Estado: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <input type="text" name="estado" value="<?=$preencherInformacoesEstado?>">
                </div>
            </div>
            <div class="row-form">
                <label for="Nome">Celular: </label>
                <div class="row-form-icon">
                    <i class="fa-solid fa-phone"></i>
                    <input type="tel" name="celular" value="<?=$preencherInformacoesCelular?>">
                </div>
            </div>
            <div class="row-form">
                <label for="Nome">Email: </label>
                    <div class="row-form-icon">
                        <i class="fa-solid fa-at"></i>
                        <input type="text" name="pais" value="<?=$preencherInformacoesEmail?>">
                    </div>
                </div>
            </div>
            <div class="end-form">
                <input type="submit" value="Atualizar">
            </div>
        </form>
    </section>
</body>
</html>