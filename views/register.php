<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/register.css">
    <script src="../assets/js/register.js" defer></script>
</head>
<body>

    <?php 

    include '../assets/php/conexao.php';

    $formUserEmail = $_POST['email'] ?? '';
    $formUserPassword = $_POST['password'] ?? '';
    $formUserRepeatPassword = $_POST['repeatpassword'] ?? '';

    $showAlert = '';
    $alertMessage = '';

    $userTypeDefault = 'user';

    date_default_timezone_set('America/Sao_Paulo');
    $userTimeRegistered =   date('d/m/Y H:i:s');

    $sql = "INSERT INTO `lista_usuarios`
    (`email`, `password`, `user_type`, `time_registered`) VALUES
    ('$formUserEmail','$formUserPassword','$userTypeDefault','$userTimeRegistered')";

    $passwordNotValue = $formUserPassword != '' && $formUserRepeatPassword != '';

    $passwordConfirm = $formUserPassword === $formUserRepeatPassword && $passwordNotValue;

    if($passwordConfirm){
        if(mysqli_query($conn, $sql)) {
            header('Location: ../login.php');
        } else {
            $showAlert = 'on';
            $alertMessage = 'Ocorreu um erro. Usuario não cadastrado!';
            
        }
    } 

    $passowordError = $formUserPassword !== $formUserRepeatPassword && $passwordNotValue;
    if($passowordError){
        $showAlert = 'on';
        $alertMessage = 'Erro. Senhas diferentes';
    }
    ?>
    <div class="back-page">
        <a href="javascript:history.back()">Voltar</a>
    </div>
    <main>
        <div class="main-header">
            <h1>Logotipo</h1>
            <h3>Crie a sua conta para acessar nosso software.</h3>
        </div>
        <div class="main-form">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post" name="formRegister">
                <label for="email">E-mail</label>
                <input type="email" name="email" value="<?=$formUserEmail?>" required>

                <label for="password">Senha: </label>
                <div class="input-container">
                    <img src="../assets/images/eyeClose.png" alt="showPassword" name="imagePassword">
                    <input type="password" name="password" value="<?=$formUserPassword?>" required>
                </div>
                
                <label for="repeatpassword">Confirme Senha: </label>
                <div class="input-container">
                    <img src="../assets/images/eyeClose.png" alt="showPassword" name="imagePassword">
                    <input type="password" name="repeatpassword" value="<?=$formUserRepeatPassword?>"required>
                </div>

                <div class="main-form-terms">
                    <input type="checkbox" name="checkbox" required>
                    <p>Concordo com os <a href="">Termos de Uso</a> e <a href="">Política de Privacidade.</a></p>
                </div>
                <div class="alert-message <?=$showAlert?>" >
                    <p><?=$alertMessage?></p>
                </div>
                <input type="submit" value="CRIAR CONTA">
            </form>
        </div>
    </main>
</body>
</html>