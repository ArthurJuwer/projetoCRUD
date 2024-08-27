<?php
    require_once 'assets/php/conect.php';
    class Login{
            protected $usuarioEmail;
            protected $usuarioSenha; 
            protected $emailSemelhantes ;
            protected $senhaSemelante;
            protected $usuarioTipo;
            protected $ultimoLogin;
            protected $mensagemAlerta;
            protected $aparecerAlerta;
            protected $mostrarAlerta;
            protected $tentativas;
            protected $TABELA = 'lista_usuarios';

            public function __construct(){
                $this-> verificarLogado();
                $this->receberDadosFormulario();
                $this->receberDadosBancoDados();
                $this->resetarTempoAlerta();
            }

            public function verificarLogado(){
                if (isset($_SESSION['email_logado']) && $_SESSION['email_logado'] != null) {
                    $this->redirecionarDeAcordoComTipoUsuario();
                }
            }

            public function resetarTempoAlerta(){
                if (isset($_GET['recarregar']) && $_GET['recarregar'] == 1) {
                    echo '<script>
                        setTimeout(function() {
                            window.location.reload();
                        }, 5000);
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
                $_SESSION['logado'] = $_POST['checkbox'] ?? '';
                if($_SESSION['logado'] == true){
                    $_SESSION['email_logado'] = $this->usuarioEmail;
                }
            }

            private function verificarTentativasUsuario(){
                
                if($this->tentativas >= 3){
                    $this->mostrarAlerta();
                    $this->mensagemAlerta = 'Erro! Este email esta suspenso por enquanto.';
                    $this->aparecerAlerta = 'on';
                    $this->enviarEmailAdmin();
                    
                } else {
                    $this->tentativas++;
                    $this->atualizarTentativasUsuario();
                }
            }
    
            private function enviarEmailAdmin() {
                $emailAdmins = ['arthurjuwer@gmail.com'];
                // pode colocar opcao de escolher um email aleatorio [numero aleatorio ao inves do 0]
                // posso adicionar uma coluna no banco de dados para caso ja tenha enviado esse email nao poder
                // evitar spam

                $para = $emailAdmins[0];
                $assunto = 'Alerta de Usuario Bloqueado';
                $mensagem = "O usuario com email '$this->usuarioEmail' foi bloqueado por errar a senha mais de 3x seguidas";
                $headers = 'From:' . $emailAdmins[0];
    
                if (!mail($para, $assunto, $mensagem, $headers)) {
                    $this->mensagemAlerta = 'Falha ao enviar o e-mail.';
                    $this->mostrarAlerta = 'on';
                }
            }

            private function atualizarTentativasUsuario(){
                $pdo = conectar();             

                $stmt = $pdo->prepare("UPDATE $this->TABELA SET attemptsEmail = :attemptsEmail WHERE email = :email");

                $stmt->bindParam(':attemptsEmail', $this->tentativas);
                $stmt->bindParam(':email', $this->usuarioEmail);

                $stmt->execute();
            }

            private function receberDadosBancoDados(){
                $pdo = conectar();

                $stmt = $pdo->prepare("SELECT * FROM $this->TABELA WHERE email LIKE :email");

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
                    $this->mostrarAlerta();
                    $this->mensagemAlerta = 'Erro! Verfique se os dados estão certos.';
                    $this->aparecerAlerta = 'on';
                    $this->verificarTentativasUsuario();
                }
            }
            protected function redirecionarDeAcordoComTipoUsuario(){
                if(isset($_SESSION['email_logado']) && $_SESSION['email_logado'] != null){
                    $_SESSION['email_usuario'] = $_SESSION['email_logado'];
                } else {
                    $_SESSION['email_usuario'] = $this->usuarioEmail;
                }
                
                $this->registrarLogin();
                if($this->usuarioTipo == 'User'){
                    header('Location: views/user/user_dashboard.php');
                    exit();
                } else {
                    header('Location: views/admin/admin_dashboard.php');
                    exit();
                
                }
            }
            private function registrarLogin(){
                $pdo = conectar();

                $stmt = $pdo->prepare("UPDATE $this->TABELA SET `lastLogin` = NOW() WHERE email = :email");
                $stmt->execute(['email' => $_SESSION['email_usuario']]); 
            }
            public function mostrarAlerta(){
                $showPopUp = [$this->aparecerAlerta, $this->mensagemAlerta];
                return $showPopUp;
            }
        }