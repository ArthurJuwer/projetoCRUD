<?php 
    class Register{
        protected $usuarioEmail;
        protected $usuarioSenha;
        protected $usuarioSenhaConfirmacao;
        protected $usuarioHorarioCadastro;
        protected $usuarioTipoPadrao = 'user';   

        public function __construct()
        {
            // quando for instanciada
            $this->receberDadosFormulario();
            $this->verificarConfirmacaoSenha();
        }

        private function receberDadosFormulario(){
            $this->usuarioEmail = $_POST['email'];
            $this->usuarioSenha = $_POST['password'];
            $this->usuarioSenhaConfirmacao = $_POST['repeatpassword'];

        }

        private function verificarConfirmacaoSenha(){

            $senhaSemValor = $this->usuarioSenha != '' && $this->usuarioSenhaConfirmacao != '';

            $senhasIgual = $this->usuarioSenha === $this->usuarioSenhaConfirmacao;

            $confirmarSenha = $senhaSemValor && $senhasIgual;

            if($confirmarSenha){
                $this->inserirDadosBanco();
            } else {
                $this->showError();
            }
        }

        private function redirecionarLogin(){
            header('Location: ../login.php');
        }
        
        // private function verificarNovoUsuario(){
        //     // fazer uma busca no banco de dados caso o email seja diferente prosseguir se nao mensagem de alerta;
        // }

        private function pegarHorarioAtual(){
            date_default_timezone_set('America/Sao_Paulo');
            $this->usuarioHorarioCadastro = date('d/m/Y H:i:s');
        }

        private function inserirDadosBanco(){

            include '../assets/php/conexao.php';

            $this->pegarHorarioAtual();

            $sql = "INSERT INTO `lista_usuarios`
            (`email`, `password`, `user_type`, `time_registered`) VALUES
            ('$this->usuarioEmail','$this->usuarioSenha','$this->usuarioTipoPadrao','$this->usuarioHorarioCadastro')";

            if(mysqli_query($conn, $sql)) {
                $this->redirecionarLogin();
            } else {
                $this->showError();
            }
        }

        private function showError(){
            echo "ERRO";
        }
    }

?>