<?php 
    class User{
        protected $emailLogado;

        public function __construct(){
            $this->obterEmailUsuarioLogado();
        }

        private function obterEmailUsuarioLogado(){
            session_start();

            if (isset($_SESSION['email_usuario'])) {
                $this->emailLogado = $_SESSION['email_usuario'];
            } else {
                $this->redirecionarLogin();
                // voltar para o login caso nao tenha email
                // MOSTRAR ALERTA DE EMAIL NAO CADADSTRADO
            }
        }
        private function redirecionarLogin(){
            header('Location: ./login.php'); 
        }
        public function getEmailLogado(){
            return $this->emailLogado;
        }
        

    }

class UserProfile extends User {
    protected $conexao;
    protected $dadosFormulario = [];

    public function __construct() {
        parent::__construct(); 
        $this->recuperarDadosUsuario();
    }

    private function recuperarDadosUsuario() {

        include '../../assets/php/conexao.php';

        $this->conexao = $conn;

        $emailLogado = $this->emailLogado;

        $sql = "SELECT * FROM lista_usuarios WHERE email = ?";
        $stmt = mysqli_prepare($this->conexao, $sql);
        mysqli_stmt_bind_param($stmt, 's', $emailLogado);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $linha = mysqli_fetch_assoc($result);

        $this->dadosFormulario = [
            'firstName' => $linha['firstName'] ?? '',
            'lastName' => $linha['lastName'] ?? '',
            'position' => $linha['position'] ?? '',
            'user_type' => $linha['user_type'] ?? '',
            'gender' => $linha['gender'] ?? '',
            'isEmployee' => $linha['isEmployee'] ?? '',
            'supervisor' => $linha['supervisor'] ?? '',
            'user_extern' => $linha['user_extern'] ?? '',
            'password' => $linha['password'] ?? '',
            'address' => $linha['address'] ?? '',
            'zipCode' => $linha['zipCode'] ?? '',
            'city' => $linha['city'] ?? '',
            'country' => $linha['country'] ?? '',
            'state' => $linha['state'] ?? '',
            'phone' => $linha['phone'] ?? '',
            'email' => $linha['email'] ?? ''
        ];
    }

    public function obterDadosFormulario() {
        $this->dadosFormulario['position'] = mysqli_real_escape_string($this->conexao, $_POST['cargo']);
        $this->dadosFormulario['firstName'] = mysqli_real_escape_string($this->conexao, $_POST['primeiroNome']);
        $this->dadosFormulario['lastName'] = mysqli_real_escape_string($this->conexao, $_POST['sobrenome']);
        $this->dadosFormulario['gender'] = mysqli_real_escape_string($this->conexao, $_POST['genero']);
        $this->dadosFormulario['isEmployee'] = mysqli_real_escape_string($this->conexao, $_POST['funcionario']);
        $this->dadosFormulario['supervisor'] = mysqli_real_escape_string($this->conexao, $_POST['supervisor']);
        $this->dadosFormulario['password'] = mysqli_real_escape_string($this->conexao, $_POST['password']);
        $this->dadosFormulario['address'] = mysqli_real_escape_string($this->conexao, $_POST['endereco']);
        $this->dadosFormulario['zipCode'] = mysqli_real_escape_string($this->conexao, $_POST['cep']);
        $this->dadosFormulario['city'] = mysqli_real_escape_string($this->conexao, $_POST['municipio']);
        $this->dadosFormulario['country'] = mysqli_real_escape_string($this->conexao, $_POST['pais']);
        $this->dadosFormulario['state'] = mysqli_real_escape_string($this->conexao, $_POST['estado']);
        $this->dadosFormulario['phone'] = mysqli_real_escape_string($this->conexao, $_POST['celular']);
    }

    public function atualizarBancoDados() {
        $sql = "UPDATE lista_usuarios SET
            position = ?,
            firstName = ?,
            lastName = ?,
            gender = ?,
            isEmployee = ?,
            supervisor = ?,
            password = ?,
            address = ?,
            zipCode = ?,
            city = ?,
            country = ?,
            state = ?,
            phone = ?
            WHERE email = ?";

        $stmt = mysqli_prepare($this->conexao, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssssssssssss',
            $this->dadosFormulario['position'],
            $this->dadosFormulario['firstName'],
            $this->dadosFormulario['lastName'],
            $this->dadosFormulario['gender'],
            $this->dadosFormulario['isEmployee'],
            $this->dadosFormulario['supervisor'],
            $this->dadosFormulario['password'],
            $this->dadosFormulario['address'],
            $this->dadosFormulario['zipCode'],
            $this->dadosFormulario['city'],
            $this->dadosFormulario['country'],
            $this->dadosFormulario['state'],
            $this->dadosFormulario['phone'],
            $this->dadosFormulario['email']
        );

        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Dados atualizados com sucesso!</p>";
        } else {
            echo "<p>Erro: " . mysqli_error($this->conexao) . "</p>";
        }
    }
}

?>