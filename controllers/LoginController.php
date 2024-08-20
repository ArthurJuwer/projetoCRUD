<?php
    require_once 'assets/php/conect.php';
    class Login{
            protected $usuarioEmail;
            protected $usuarioSenha; 
            protected $emailSemelhantes ;
            protected $senhaSemelante ;
            protected $usuarioTipo;
            protected $ultimoLogin;
            protected $messageError;
            protected $showError;
            protected $mostrarAlerta;
            protected $tentativas;

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
                $this->usuarioEmail = $_POST['email'] ?? '';
                $this->usuarioSenha = $_POST['password'] ?? '';
            }

            private function verificarTentativasUsuario(){
                
                if($this->tentativas >= 3){
                    $this->mostrarErro();
                    $this->messageError = 'Erro! Este email esta suspenso por enquanto.';
                    $this->showError = 'on';
                    
                } else {
                    $this->tentativas++;
                    $this->atualizarTentativasUsuario();
                }
            }
            private function atualizarTentativasUsuario(){
                $pdo = conectar();

                $TABELA = 'lista_usuarios';

                $stmt = $pdo->prepare("UPDATE $TABELA SET attemptsEmail = :attemptsEmail WHERE email = :email");

                $stmt->bindParam(':attemptsEmail', $this->tentativas);
                $stmt->bindParam(':email', $this->usuarioEmail);

                $stmt->execute();
            }

            private function receberDadosBancoDados(){
                $pdo = conectar();

                $TABELA = 'lista_usuarios';

                $stmt = $pdo->prepare("SELECT * FROM $TABELA WHERE email LIKE :email");

                $stmt->execute( array ( 'email' => '%' . $this->usuarioEmail . '%' ) );

                $dados = $stmt->fetch();

                $this->emailSemelhantes = $dados['email'] ?? 'valor invalido';
                $this->senhaSemelante = $dados['password'] ?? 'valor invalido';
                $this->tentativas = $dados['attemptsEmail'] ?? 'valor invalido';
                $this->usuarioTipo = $dados['user_type'] ?? 'valor invalido';

            }
            public function verificarSemelhancasDados(){
                $valoresIguaisBancoDadosFormulario = ($this->usuarioEmail == $this->emailSemelhantes && $this->usuarioSenha == $this->senhaSemelante);

                $usuarioNaoEstaSuspenso = ($this->tentativas < 3);

                if($valoresIguaisBancoDadosFormulario && $usuarioNaoEstaSuspenso) {   
                    $this->redirecionarDeAcordoComTipoUsuario();
                } else {
                    $this->mostrarErro();
                    $this->messageError = 'Erro! Verfique se os dados estão certos.';
                    $this->showError = 'on';
                    $this->verificarTentativasUsuario();
                }
            }
            protected function redirecionarDeAcordoComTipoUsuario(){
                session_start();

                $_SESSION['email_usuario'] = $this->usuarioEmail;
                $this->registrarLogin();
                if($this->usuarioTipo == 'User'){
                    header('Location: views/user/user_dashboard.php');
                } else {
                    header('Location: views/admin/admin_dashboard.php');
                }
            }
            private function registrarLogin(){
                $pdo = conectar();
                $TABELA = 'lista_usuarios';

                $stmt = $pdo->prepare("UPDATE $TABELA SET `lastLogin` = NOW() WHERE email = :email");
                $stmt->execute(['email' => $this->usuarioEmail]);
            }
            public function mostrarErro(){
                $showPopUp = [$this->showError, $this->messageError];
                return $showPopUp;
            }
        }