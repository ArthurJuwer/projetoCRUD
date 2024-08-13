<?php
class Login{
        protected $userEmail;
        protected $userPassword; 
        protected $emailSemelhantes ;
        protected $passwordSemelhantes ;
        protected $userType;

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
            include './assets/php/conexao.php';
            $sql = "SELECT * FROM lista_usuarios WHERE email LIKE '%$this->userEmail%'";

            if($dados = mysqli_query($conn, $sql)){
                $linha = mysqli_fetch_assoc($dados);
            }

            $this->emailSemelhantes = $linha['email'] ?? 'valor invalido';
            $this->passwordSemelhantes = $linha['password'] ?? 'valor invalido';
            $this->userType = $linha['user_type'] ?? 'valor invalido';

            
            
        }
        public function verificarSemelhancasDados(){
            $valoresIguaisDataBaseAndForm = ($this->userEmail == $this->emailSemelhantes && $this->userPassword == $this->passwordSemelhantes);
    
            if($valoresIguaisDataBaseAndForm) {   
                $this->redirecionarDeAcordoComTipoUsuario();
            } else {
                $this->mostrarErro();
            }
            
        }
        protected function redirecionarDeAcordoComTipoUsuario(){
            session_start();

            $_SESSION['nome_usuario'] = $this->userEmail;
            if($this->userType == 'user'){
                header('Location: views/user/user_dashboard.php');
            } else {
                header('Location: views/admin/admin_dashboard.php');
            }
        }
        protected function mostrarErro(){
            // $showAlert = 'on';
            echo "definir depois. ERRO";
            
        }
    }