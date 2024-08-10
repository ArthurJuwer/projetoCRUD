<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>

    <?php 

    include './conexao.php';

    

    $formUserEmail = $_POST['email'] ?? '';
    $formUserPassword = $_POST['password'] ?? '';

    $showAlert = '';

    $userType = 'default';

    date_default_timezone_set('America/Sao_Paulo');
    $userTimeRegistered =   date('d/m/Y H:i:s');

    $sql = "INSERT INTO `lista_usuarios`
    (`email`, `password`, `user_type`, `time_registered`) VALUES
    ('$formUserEmail','$formUserPassword','$userType','$userTimeRegistered')";

    if($formUserEmail != '' && $formUserPassword != ''){
        if(mysqli_query($conn, $sql)) {
            header('Location: ../pages/examplePage.html');
        } else {
            $showAlert = 'on';
        }
    }
    
    ?>
    
    <main>
        <div class="main-header">
            <h1>Logotipo</h1>
            <h3>Crie a sua conta para acessar nosso software.</h3>
        </div>
        <div class="main-form">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <label for="email">E-mail</label>
                <input type="email" name="email" required>
                <label for="password">Password</label>
                <input type="text" name="password" required>
                <label for="repeatpassword">Repeat Password</label>
                <input type="text" name="repeatpassword" required>
                <div class="main-form-terms">
                    <input type="checkbox" name="checkbox" required>
                    <p>Concordo com os <a href="">Termos de Uso</a> e <a href="">Política de Privacidade.</a></p>
                </div>
                <div class="alert-message <?=$showAlert?>" >
                    <p>Ocorreu um erro usuario não cadastrado.</p>
                </div>
                <input type="submit" value="CRIAR CONTA">
            </form>
        </div>
    </main>
</body>
</html>