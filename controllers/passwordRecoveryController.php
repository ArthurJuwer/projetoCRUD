<?php
    require_once '../assets/php/conect.php';
    class PasswordRecovery {
        protected $emailFormulario;
        protected $codigoFormulario;
        protected $etapa;
        protected $codigoAleatorio;
        protected $mensagemAlerta;
        protected $mostrarAlerta;
        protected $fraseDestaque;
        protected $mostrarFormularioEmail;
        protected $mostrarFormularioCodigo;
        protected $mostrarFormularioSenha;
        protected $TABELA = 'lista_usuarios';

        public function __construct() {
            $this->iniciarSessao();
            $this->inicializarVariaveis();
            $this->processarRequisicao();
        }

        private function iniciarSessao() {
            session_start();

            if (!isset($_SESSION['inicializado'])) {
                session_unset();
                session_destroy();
                session_start();
                $_SESSION['inicializado'] = true;
            }
        }

        private function inicializarVariaveis() {
            $this->emailFormulario = $_POST['email'] ?? '';
            $this->codigoFormulario = $_POST['cod'] ?? '';
            $this->etapa = $_SESSION['etapa'] ?? 1;

            if ($this->etapa === 1) {
                $this->codigoAleatorio = mt_rand(1000, 5000);
                $_SESSION['codigoAleatorio'] = $this->codigoAleatorio;
            } else {
                $this->codigoAleatorio = $_SESSION['codigoAleatorio'] ?? '';
            }

            $this->mensagemAlerta = '';
            $this->mostrarAlerta = '';
            $this->fraseDestaque = 'Primeiro digite seu email para mandarmos um novo código.';
            $this->mostrarFormularioEmail = $this->etapa === 1 ? 'on' : '';
            $this->mostrarFormularioCodigo = $this->etapa === 2 ? 'on' : '';
            $this->mostrarFormularioSenha = $this->etapa === 3 ? 'on' : '';
        }

        private function processarRequisicao() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                switch ($this->etapa) {
                    case 1:
                        $this->tratarEtapa1();
                        break;
                    case 2:
                        $this->tratarEtapa2();
                        break;
                    case 3:
                        $this->tratarEtapa3();
                        break;
                }
            } else {
                $this->atualizarFormularios();
            }
        }

        private function tratarEtapa1() {
            if ($this->verificarEmailExiste()) {
                $this->enviarEmail();
                $this->fraseDestaque = "Informe o código enviado para $this->emailFormulario no campo abaixo.";
                $this->etapa = 2;
                $_SESSION['etapa'] = $this->etapa;
                $_SESSION['email'] = $this->emailFormulario;
                $this->mostrarFormularioCodigo = 'on';
                $this->mostrarFormularioEmail = '';
            } else {
                if ($this->emailFormulario !== '') {
                    $this->mensagemAlerta = 'Este e-mail não foi cadastrado.';
                    $this->mostrarAlerta = 'on';
                    $this->mostrarFormularioEmail = 'on';
                }
            }
            $this->atualizarFormularios();
        }

        private function verificarEmailExiste() {
            $pdo = conectar();

            $stmt = $pdo->prepare("SELECT email FROM $this->TABELA WHERE email = :email");
            $stmt->bindParam(':email', $this->emailFormulario);
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        private function enviarEmail() {
            $para = $this->emailFormulario;
            $assunto = 'Recuperação de senha';
            $mensagem = "Use o código a seguir para criar uma nova senha.\nSe você não solicitou esse código, não precisa se preocupar.\nBasta ignorar este e-mail.\nCÓDIGO: " . $this->codigoAleatorio;
            $headers = 'From:' . $this->emailFormulario;

            if (!mail($para, $assunto, $mensagem, $headers)) {
                $this->mensagemAlerta = 'Falha ao enviar o e-mail.';
                $this->mostrarAlerta = 'on';
            }
        }

        private function tratarEtapa2() {
            if ($this->codigoFormulario == $this->codigoAleatorio) {
                $this->etapa = 3;
                $_SESSION['etapa'] = $this->etapa;
                $this->mostrarFormularioSenha = 'on';
                $this->fraseDestaque = "Preencha os campos com a nova senha.";
                $this->mostrarFormularioCodigo = '';
            } else {
                $this->mensagemAlerta = 'Você digitou o código errado.';
                $this->mostrarAlerta = 'on';
                $this->mostrarFormularioCodigo = 'on';
                $this->fraseDestaque = 'Informe o código enviado para ' . $_SESSION['email'] . ' no campo abaixo.';
            }
            $this->atualizarFormularios();
        }

        private function tratarEtapa3() {
            $senha = $_POST['password'] ?? '';
            $senhaRepetida = $_POST['repeatpassword'] ?? '';

            if ($senha === $senhaRepetida) {
                $this->atualizarSenha($senha);
                $_SESSION['inicializado'] = false;
                $_SESSION['etapa'] = 1;
                $this->redirecionarLogin();
                exit;
            } else {
                $this->mensagemAlerta = 'Verifique se as senhas estão iguais.';
                $this->mostrarAlerta = 'on';
                $this->mostrarFormularioSenha = 'on';
                $this->fraseDestaque = "Preencha os campos com a nova senha.";
            }
            $this->atualizarFormularios();
        }
        private function redirecionarLogin(){
            $this->alertaLogin();
            header('Location: ../login.php');
        }
        private function alertaLogin(){
            session_start();
            $_SESSION['mensagem_alerta'] = 'Senha atualizada com sucesso';
            $_SESSION['mostrar_alerta'] = 'on';
        }

        private function atualizarSenha($senha) {
            $pdo = conectar();

            $emailSalvo = $_SESSION['email'];
            $stmt = $pdo->prepare("UPDATE $this->TABELA SET password = :senha WHERE email = :email");
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':email', $emailSalvo);
            $stmt->execute();
        }

        private function atualizarFormularios() {
            $this->mostrarFormularioEmail = $this->etapa === 1 ? 'on' : '';
            $this->mostrarFormularioCodigo = $this->etapa === 2 ? 'on' : '';
            $this->mostrarFormularioSenha = $this->etapa === 3 ? 'on' : '';
        }

        public function obterMostrarAlerta() {
            return $this->mostrarAlerta;
        }

        public function obterMensagemAlerta() {
            return $this->mensagemAlerta;
        }

        public function obterFraseDestaque() {
            return $this->fraseDestaque;
        }

        public function obterMostrarFormularioEmail() {
            return $this->mostrarFormularioEmail;
        }

        public function obterMostrarFormularioCodigo() {
            return $this->mostrarFormularioCodigo;
        }

        public function obterMostrarFormularioSenha() {
            return $this->mostrarFormularioSenha;
        }
    }

?>
