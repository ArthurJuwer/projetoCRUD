<?php
class Login{
        protected $userEmail;
        protected $userPassword; 
        protected $emailSemelhantes ;
        protected $passwordSemelhantes ;
        protected $userType;
        protected $messageError;
        protected $showError;

        public function __construct(){
        // Este método será chamado quando a instância for criada
        $this->receberDadosFormulario();
        $this->receberDadosBancoDados();

        }

        private function receberDadosFormulario(){
            $this->userEmail = $_POST['email'] ?? '';
            $this->userPassword = $_POST['password'] ?? '';
        }
        private function receberDadosBancoDados(){
            include './assets/php/conect.php';

            $pdo = conectar();

            $TABELA = 'lista_usuarios';

            $stmt = $pdo->prepare("SELECT * FROM $TABELA WHERE email LIKE :email");

            $stmt->execute( array ( 'email' => '%' . $this->userEmail . '%' ) );

            $dados = $stmt->fetch();

            $this->emailSemelhantes = $dados['email'] ?? 'valor invalido';
            $this->passwordSemelhantes = $dados['password'] ?? 'valor invalido';
            $this->userType = $dados['user_type'] ?? 'valor invalido';

            
            
        }
        public function verificarSemelhancasDados(){
            $valoresIguaisDataBaseAndForm = ($this->userEmail == $this->emailSemelhantes && $this->userPassword == $this->passwordSemelhantes);
    
            if($valoresIguaisDataBaseAndForm) {   
                $this->redirecionarDeAcordoComTipoUsuario();
            } else {
                $this->mostrarErro();
                $this->messageError = 'Erro! Verfique se os dados estão certos.';
                $this->showError = 'on';
            }
            
        }
        protected function redirecionarDeAcordoComTipoUsuario(){
            session_start();

            $_SESSION['email_usuario'] = $this->userEmail;
            if($this->userType == 'user'){
                header('Location: views/user/user_dashboard.php');
            } else {
                header('Location: views/admin/admin_dashboard.php');
            }
        }
        public function mostrarErro(){
            $showPopUp = [$this->showError, $this->messageError];
            return $showPopUp;
            
        }
    }