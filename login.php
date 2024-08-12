<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="assets/js/login.js" defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"async defer></script>
</head>
<body>
    <?php 
    
    include './assets/php/conexao.php';


session_start();

if (($_SESSION['initialized']) == false) {

    session_unset(); 
    session_destroy(); 
    session_start(); 
    

    $_SESSION['initialized'] = true;
}
    

        $_SESSION['tentativas'] ?? 0;
    

    echo $_SESSION['tentativas'];
    $formUserEmailRegistered = $_POST['email'] ?? '';

    $formUserPasswordRegistered = $_POST['password'] ?? '';

    $showAlert = '';

function registrarTentativa() {
    $_SESSION['tentativas']++;
}

    if($_SESSION['tentativas'] < 3){
        $sql = "SELECT * FROM lista_usuarios WHERE email LIKE '%$formUserEmailRegistered%'";

        $dados = mysqli_query($conn, $sql);
        $linha = mysqli_fetch_assoc($dados);

        $emailSemelhantes = $linha['email'] ?? 'valor invalido';
        $passwordSemelhantes = $linha['password'] ?? 'valor invalido';

        $userType = $linha['user_type'] ?? 'valor invalido';

        if($formUserEmailRegistered != ''){

            $valoresIguaisDataBaseAndForm = ($formUserEmailRegistered == $emailSemelhantes && $formUserPasswordRegistered == $passwordSemelhantes);

            if($valoresIguaisDataBaseAndForm) {   
                
                session_start();

                $_SESSION['nome_usuario'] = $formUserEmailRegistered;
                if($userType == 'user'){
                    header('Location: assets/pages/user/user_dashboard.php');
                    $_SESSION['initialized'] == false;
                } else {
                    header('Location: assets/pages/admin/admin_dashboard.php');
                    $_SESSION['initialized'] == false;
                }
                
                $showAlert = '';
            } else {
                $showAlert = 'on';
                registrarTentativa();
            }
        }
    } else {
        echo "PASSOU TENTATIVAS";
    }
    

    
    

    ?>
    <main>
        <div class="main-header">
            <h1>Logotipo</h1>
            <h3>Slogan rápido e explicativo.</h3>
        </div>
        <div class="main-form">
            <form id="login-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <label for="email">E-mail</label>
                <input type="email" name="email" value="<?=$formUserEmailRegistered?>" required>
                <label for="password">Password</label>
                <div class="input-container">
                    <img src="./assets/images/eyeClose.png" alt="showPassword" name="imagePassword">
                    <input type="password" name="password" value="<?=$formUserPasswordRegistered?>" required>
                </div>
                <div class="main-form-links">
                    <a href="assets/pages/passwordRecovery.php">Esqueceu sua senha?</a>
                </div>
                <div class="alert-message <?=$showAlert?>" >
                    <p>Verifique se o email ou senha estão corretos.</p>
                </div>
                <div class="container-captchaba">
                    <div class="g-recaptcha" data-sitekey="6Ld8fCUqAAAAAOiYndpCU3FOxAjvyWH5elRCeNyl"></div>
                </div>
                <br/>
                <input type="submit" value="ENTRAR">
                <p>Não tem conta? <a href="assets/pages/register.php">Criar Conta</a></p>
            </form>
        </div>
    </main>
</body>
</html>