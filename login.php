<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <?php 

    include './assets/php/conexao.php';

    $formUserEmailRegistered = $_POST['email'] ?? '';

    $formUserPasswordRegistered = $_POST['password'] ?? '';

    $showAlert = '';

    $sql = "SELECT * FROM lista_usuarios WHERE email LIKE '%$formUserEmailRegistered%'";

    $dados = mysqli_query($conn, $sql);
    $linha = mysqli_fetch_assoc($dados);

    $emailSemelhantes = $linha['email'] ?? 'valor invalido';
    $passwordSemelhantes = $linha['password'] ?? 'valor invalido';

    if($formUserEmailRegistered != ''){
        if($formUserEmailRegistered == $emailSemelhantes && $formUserPasswordRegistered == $passwordSemelhantes) {    
            header('Location: assets/pages/examplePage.html');
            $showAlert = '';
        } else {
            $showAlert = 'on';
        }
    }

    ?>
    <main>
        <div class="main-header">
            <h1>Logotipo</h1>
            <h3>Slogan rápido e explicativo.</h3>
        </div>
        <div class="main-form">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <label for="email">E-mail</label>
                <input type="email" name="email" value="<?=$formUserEmailRegistered?>" required>
                <label for="password">Password</label>
                <input type="text" name="password" value="<?=$formUserPasswordRegistered?>" required>
                <div class="main-form-links">
                    <a href="">Esqueceu sua senha?</a>
                </div>
                <div class="alert-message <?=$showAlert?>" >
                    <p>Verifique se o email ou senha estão corretos.</p>
                </div>
                <input type="submit" value="ENTRAR">
                <p>Não tem conta? <a href="assets/php/register.php">Criar Conta</a></p>
            </form>
        </div>
    </main>
</body>
</html>