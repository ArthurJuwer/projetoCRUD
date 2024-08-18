<?php 
    require_once '../assets/php/conect.php';
        class Register{
        protected $usuarioEmail;
        protected $usuarioSenha;
        protected $usuarioSenhaConfirmacao;
        protected $usuarioHorarioCadastro;
        protected $usuarioTipoPadrao = 'User'; 
        protected $usuarioTipoCriado = 'Interno'; 
        protected $showError;
        protected $messageError;

        public function __construct()
        {
            $this->receberDadosFormulario();
            $this->verificacoesConcluidas();
            
        }

        private function receberDadosFormulario(){
            $this->usuarioEmail = $_POST['email'];
            $this->usuarioSenha = $_POST['password'];
            $this->usuarioSenhaConfirmacao = $_POST['repeatpassword'];

        }

        private function verificarConfirmacaoSenha(){

            $senhaSemValor = $this->usuarioSenha != '' && $this->usuarioSenhaConfirmacao != '';

            $senhasIgual = $this->usuarioSenha === $this->usuarioSenhaConfirmacao;

            return $senhaSemValor && $senhasIgual;

        }
        private function verificarUsuarioNovo() {
            $pdo = conectar();
            
            $stmt = $pdo->prepare("SELECT email FROM lista_usuarios WHERE email = :email");
            $stmt->bindParam(':email', $this->usuarioEmail);
            $stmt->execute();
            
            $resultado = $stmt->fetchColumn();
            
            return $resultado !== false;
        }
        
        private function verificacoesConcluidas() {
            if ($this->verificarUsuarioNovo()) {
                $this->showError = 'on';
                $this->messageError = 'Erro! Usuário já cadastrado';
                $this->mostrarErro();
            } else {
                if ($this->verificarConfirmacaoSenha()) {
                    $this->inserirDadosBanco();
                    $this->redirecionarLogin();
                } else {
                    $this->showError = 'on';
                    $this->messageError = 'Erro! Verifique se as senhas são idênticas';
                    $this->mostrarErro();
                }
            }
        }
        
        private function redirecionarLogin() {
            header('Location: ../login.php');
            exit();
        }
        
        private function pegarHorarioAtual(){
            date_default_timezone_set('America/Sao_Paulo');
            $this->usuarioHorarioCadastro = date('d/m/Y H:i:s');
        }

        private function inserirDadosBanco() {        
            $this->pegarHorarioAtual();
        
            $pdo = conectar();
            $TABELA = 'lista_usuarios';
        
            $stmt = $pdo->prepare("INSERT INTO $TABELA 
            (`email`, `password`, `user_type`, `user_extern`,`time_registered`) VALUES
            (:email, :password, :user_type,:user_extern, :time_registered)");
        
            $stmt->bindParam(':email', $this->usuarioEmail);
            $stmt->bindParam(':password', $this->usuarioSenha);
            $stmt->bindParam(':user_type', $this->usuarioTipoPadrao);
            $stmt->bindParam(':user_extern', $this->usuarioTipoCriado);
            $stmt->bindParam(':time_registered', $this->usuarioHorarioCadastro);
        
            if ($stmt->execute()) {
                $this->redirecionarLogin();
            } else {
                $this->mostrarErro();
                $this->showError = 'on';
                $this->messageError = 'Erro! não foi possivel inserir no Banco de Dados';
            }
        }
        
        public function mostrarErro(){
            $showPopUp = [$this->showError, $this->messageError];
            return $showPopUp;
        }
    }
?>