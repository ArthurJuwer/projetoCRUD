<?php 
class User {
    protected $emailLogado;
    protected $mostrarPop;
    protected $mensagemPop;

    public function __construct() {
        $this->obterEmailUsuarioLogado();
    }

    private function obterEmailUsuarioLogado() {
        session_start();

        if (isset($_SESSION['email_usuario'])) {
            $this->emailLogado = $_SESSION['email_usuario'];
        } else {
            $this->redirecionarLogin();
        }
    }

    private function redirecionarLogin() {
        header('Location: ./login.php'); 
        exit();
    }

    public function getEmailLogado() {
        return $this->emailLogado;
    }
}

class UserProfile extends User {
    public $dadosFormulario = [];

    public function __construct() {
        parent::__construct(); 
        $this->recuperarDadosUsuario();
    }

    public function recuperarDadosUsuario(){
        include '../../assets/php/conect.php';
        $pdo = conectar();
        $TABELA = 'lista_usuarios';
        $stmt = $pdo->prepare("SELECT * FROM $TABELA WHERE email = :email");
        $stmt->bindParam(':email', $this->emailLogado);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);

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
        $this->dadosFormulario['position'] = $_POST['cargo'] ?? '';
        $this->dadosFormulario['firstName'] = $_POST['primeiroNome'] ?? '';
        $this->dadosFormulario['lastName'] = $_POST['sobrenome'] ?? '';
        $this->dadosFormulario['gender'] = $_POST['genero'] ?? '';
        $this->dadosFormulario['isEmployee'] = $_POST['funcionario'] ?? '';
        $this->dadosFormulario['supervisor'] = $_POST['supervisor'] ?? '';
        $this->dadosFormulario['password'] = $_POST['password'] ?? '';
        $this->dadosFormulario['address'] = $_POST['endereco'] ?? '';
        $this->dadosFormulario['zipCode'] = $_POST['cep'] ?? '';
        $this->dadosFormulario['city'] = $_POST['municipio'] ?? '';
        $this->dadosFormulario['country'] = $_POST['pais'] ?? '';
        $this->dadosFormulario['state'] = $_POST['estado'] ?? '';
        $this->dadosFormulario['phone'] = $_POST['celular'] ?? '';
    }

    public function atualizarBancoDados() {
        $pdo = conectar();
        $stmt = $pdo->prepare("UPDATE lista_usuarios SET
            position = :position,
            firstName = :firstName,
            lastName = :lastName,
            gender = :gender,
            isEmployee = :isEmployee,
            supervisor = :supervisor,
            password = :password,
            address = :address,
            zipCode = :zipCode,
            city = :city,
            country = :country,
            state = :state,
            phone = :phone
            WHERE email = :email");
        $stmt->bindParam(':position', $this->dadosFormulario['position']);
        $stmt->bindParam(':firstName', $this->dadosFormulario['firstName']);
        $stmt->bindParam(':lastName', $this->dadosFormulario['lastName']);
        $stmt->bindParam(':gender', $this->dadosFormulario['gender']);
        $stmt->bindParam(':isEmployee', $this->dadosFormulario['isEmployee']);
        $stmt->bindParam(':supervisor', $this->dadosFormulario['supervisor']);
        $stmt->bindParam(':password', $this->dadosFormulario['password']);
        $stmt->bindParam(':address', $this->dadosFormulario['address']);
        $stmt->bindParam(':zipCode', $this->dadosFormulario['zipCode']);
        $stmt->bindParam(':city', $this->dadosFormulario['city']);
        $stmt->bindParam(':country', $this->dadosFormulario['country']);
        $stmt->bindParam(':state', $this->dadosFormulario['state']);
        $stmt->bindParam(':phone', $this->dadosFormulario['phone']);
        $stmt->bindParam(':email', $this->dadosFormulario['email']);

        if ($stmt->execute()) {
            echo "<p>Dados atualizados com sucesso!</p>";
            // mostrarPopup()
            // $mostrarPop = 'on'
            // $mensagemPop = 'Dados atualizados com sucesso!'
        } else {
            echo "<p>Erro ao atualizar dados.</p>";
            // mostrarPopup()
            // $mostrarPop = 'on'
            // $mensagemPop = 'Erro ao atualizar dados.'
        }
    }
    public function mostrarPopup(){
        // $showPopUp = [$this->mostrarPop, $this->mensagemPop];
        // return $showPopUp;
    }
}
?>