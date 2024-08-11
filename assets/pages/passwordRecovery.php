<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remember Password</title>
    <link rel="stylesheet" href="../css/passwordRecovery.css">
</head>
<body>
<?php

## FALTA ESCONDER OS CARACTERES E DAR A OPCAO DE MOSTRAR
## VERIFICAR SE O EMAIL É IGUAL A UM EXISTENTE NO DB
## FAZER O SQL PARA ALTERAR A SENHA DO EMAIL, VER COMO E NO REGISTER  A PARTE DE SER O MESMO EMAIL E SENHA LIKE


session_start();

// Verifica se a sessão acabou de começar
if (($_SESSION['initialized']) == false) {
    // Primeira vez que a página é acessada nesta sessão, resetar a sessão
    session_unset(); // Remove todas as variáveis de sessão
    session_destroy(); // Destroi a sessão
    session_start(); // Reinicia a sessão
    
    // Define que a sessão foi inicializada
    $_SESSION['initialized'] = true;
}

$emailForm = $_POST['email'] ?? '';
$codForm = $_POST['cod'] ?? '';
$step = $_SESSION['step'] ?? 1;

$fraseDestaque = 'Primeiro digite seu email para mandarmos um novo código.';

$showVerificationEmail = 'on';
$showVerificationCod = '';
$showVerificationPassword = '';

if (!isset($_SESSION['randomCod'])) {
    $randomCod = mt_rand(1000, 5000);
    $_SESSION['randomCod'] = $randomCod;
}

include '../php/conexao.php';



if ($step == 1) {
    $para = $emailForm;
    $assunto = 'Recuperação de senha';
    $mensagem = "Use o código a seguir para criar uma nova senha. 
    Se você não solicitou esse código, não precisa se preocupar. 
    Basta ignorar este e-mail.
    CODIGO: " . $_SESSION['randomCod'];
    $headers = 'From:' . $emailForm;

    if (mail($para, $assunto, $mensagem, $headers)) {
        $fraseDestaque = "Informe o código enviado para $emailForm no campo abaixo.";
        $step = 2;
        $_SESSION['step'] = $step;
        $showVerificationCod = 'on';
        $showVerificationEmail = '';
        $showVerificationPassword = '';
    } else {
        $showAlert = 'on';
    } 
} elseif ($step == 2) {
    $showAlert = '';
    if($codForm == $_SESSION['randomCod']){
        $step = 3;
        $_SESSION['step'] = $step;
        $showVerificationCod = '';
        $showVerificationEmail = '';
        $showVerificationPassword = 'on';
        $fraseDestaque = "Preencha os campos com a nova senha.";

    } else {
        $showVerificationCod = 'on';
        $showVerificationEmail = '';
        $showVerificationPassword = '';
        $fraseDestaque = "Informe o código correto enviado para $emailForm.";
    }
    
} elseif ($step == 3) {
    $password = $_POST['password'] ?? '';
    $repeatPassword = $_POST['repeatpassword'] ?? '';
    $passwordConfirm = $password === $repeatPassword;

    if($passwordConfirm){
        $_SESSION['step'] = $step;
        $_SESSION['initialized'] = false;
        header('Location: ../../login.php');
        exit;
    } else {
        $showVerificationCod = '';
        $showVerificationEmail = '';
        $showVerificationPassword = 'on';
        $fraseDestaque = "Verifique se as senhas estão iguais.";
    }

}

?>
    <main>
        
    
        <div class="main-header">
            <h1>Logotipo</h1>
            <h3><?=$fraseDestaque?></h3>
        </div>
        
        <form class="<?=$showVerificationEmail?>" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <div class="info-form">
                <label for="email">Digite seu email: </label>
                <input type="email" name="email" required>
                <input type="submit" value="ENVIAR">
            </div> 
            
        </form>
        <form class="<?=$showVerificationCod?>" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <div class="info-form">
                <label for="cod">Digite o código: </label>
                <input type="text" name="cod">
                <input type="submit" value="PRÓXIMO">
            </div>
        </form>

        <form class="<?=$showVerificationPassword?>" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <div class="info-form">
                <label for="password">Digite sua nova senha: </label>
                <input type="text" name="password">
                <label for="repeatpassword">Confirme a senha: </label>
                <input type="text" name="repeatpassword">
                <input type="submit" value="SALVAR">
            </div>
        </form>
        <div class="alert-error <?=$showAlert?>">
            <p>Falha ao enviar o e-mail.<p>
        </div>
    </main>
</body>
</html>