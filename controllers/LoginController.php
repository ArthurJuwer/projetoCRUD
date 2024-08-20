<?php
    require_once 'assets/php/conect.php';
    class Login{
            protected $userEmail;
            protected $userPassword; 
            protected $emailSemelhantes ;
            protected $passwordSemelhantes ;
            protected $userType;
            protected $messageError;
            protected $showError;
            protected $mostrarAlerta;

            public function __construct(){
                $this->receberDadosFormulario();
                $this->receberDadosBancoDados();
                $this->resetarTempoAlerta();
            }

            public function resetarTempoAlerta(){
                if (isset($_GET['recarregar']) && $_GET['recarregar'] == 1) {
                    echo '<script>
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000); // Recarrega a página após 5 segundos
                    </script>';
                    $this->resetarVariaveisAlerta();
                }
            }
            private function resetarVariaveisAlerta(){
                unset($_SESSION['mostrar_alerta']);
                unset($_SESSION['mensagem_alerta']);
            }

            private function receberDadosFormulario(){
                $this->userEmail = $_POST['email'] ?? '';
                $this->userPassword = $_POST['password'] ?? '';
            }
            private function receberDadosBancoDados(){
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
                if($this->userType == 'User'){
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