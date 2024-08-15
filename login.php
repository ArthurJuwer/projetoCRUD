<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="assets/js/login.js" defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <?php 

    require_once './controllers/LoginController.php';
    $login = new Login;
    $login->verificarSemelhancasDados()
    ?>
    <main>
        <div class="main-header">
            <h1>Logotipo</h1>
            <h3>Slogan rápido e explicativo.</h3>
        </div>
        <div class="main-form">
            <form id="login-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <label for="email">E-mail</label>
                <input type="email" name="email" required>
                <label for="password">Password</label>
                <div class="input-container">
                    <img src="./assets/images/eyeClose.png" alt="showPassword" name="imagePassword">
                    <input type="password" name="password" required>
                </div>
                <div class="main-form-links">
                    <a href="views/passwordRecovery.php">Esqueceu sua senha?</a>
                </div>
                <div class="alert-message" >
                    <p>Verifique se o email ou senha estão corretos.</p>
                </div>
                <input type="submit" value="ENTRAR" class="g-recaptcha" data-sitekey="6LcVPCYqAAAAAFzQf0v3u4C10h6RFTYOgKJYpogE" data-callback="onSubmit">
                <p>Não tem conta? <a href="views/register.php">Criar Conta</a></p>
            </form>
        </div>
    </main>
</body>
</html>