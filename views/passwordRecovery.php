<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha</title>
    <link rel="stylesheet" href="../assets/css/passwordRecovery.css">
    <script src="../assets/js/passwordRecovery.js" defer></script>
</head>
<body>
<?php 
        require_once "../controllers/passwordRecoveryController.php";
        $passwordRecovery = new PasswordRecovery();
    ?>
    <div class="back-page">
        <a href="javascript:history.back()">Voltar</a>
    </div>
    <main>
        <div class="main-header">
            <h1>Logotipo</h1>
            <h3><?= $passwordRecovery->obterFraseDestaque() ?></h3>
        </div>
        
        <form class="<?= $passwordRecovery->obterMostrarFormularioEmail() ?>" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="info-form">
                <label for="email">Digite seu email: </label>
                <input type="email" name="email" required>
                <input type="submit" value="ENVIAR">
            </div> 
        </form>

        <form class="<?= $passwordRecovery->obterMostrarFormularioCodigo() ?>" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="info-form">
                <label for="cod">Digite o código: </label>
                <input type="text" name="cod">
                <input type="submit" value="PRÓXIMO">
            </div>
        </form>

        <form class="<?= $passwordRecovery->obterMostrarFormularioSenha() ?>" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="info-form">
                <label for="password">Digite a senha: </label>
                <div class="input-container">
                    <img src="../assets/images/eyeClose.png" alt="showPassword" name="imagePassword">
                    <input type="password" name="password" required>
                </div>
                
                <label for="repeatpassword">Confirme a senha:</label>
                <div class="input-container">
                    <img src="../assets/images/eyeClose.png" alt="showPassword" name="imagePassword">
                    <input type="password" name="repeatpassword" required>
                </div>
                <input type="submit" value="SALVAR">
            </div>
        </form>

        <div class="<?= $passwordRecovery->obterMostrarAlerta() ?> alert-error">
            <p><?= $passwordRecovery->obterMensagemAlerta() ?></p>
        </div>
    </main>
</body>
</html>
