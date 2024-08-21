<?php 
require_once '../../assets/php/conect.php';
    class Admin{
        protected $usuarioEmail; 
        protected $mostrarPop;
        protected $corPop;
        protected $mensagemPop;

        public function __construct(){
            $this->obterEmailAdmin();
            $this->atualizarTentativasUsuario();
            
        }

        private function atualizarTentativasUsuario(){
            $pdo = conectar();

            $TABELA = 'lista_usuarios';

            $RESETAR_TENTATIVAS = 0;

            $stmt = $pdo->prepare("UPDATE $TABELA SET attemptsEmail = :attemptsEmail WHERE email = :email");
            $stmt->bindParam(':attemptsEmail', $RESETAR_TENTATIVAS);
            $stmt->bindParam(':email', $this->usuarioEmail);
            $stmt->execute();
        }

        private function obterEmailAdmin(){
            session_start();
            if (isset($_SESSION['email_usuario'])) {
                $this->usuarioEmail = $_SESSION['email_usuario'];
            } else {
                $this->redirecionarLogin();
            }

        }
        private function redirecionarLogin() {
            header('Location: ../../login.php'); 
            $this->alertaLogin();
            exit();
        }
        private function alertaLogin(){
            session_start();
            $_SESSION['mensagem_alerta'] = 'Logue na sua conta para acessar o painel';
            $_SESSION['mostrar_alerta'] = 'red on';
        }

        public function getEmailLogado(){
            return $this->usuarioEmail;
        }
    }

    class AdminReadDataBase extends Admin{

        ## adicionar uma opção de pesquisar e uma opção de excluir

        protected $dadosRecuperados;
        protected $valorlinha;

        public function __construct(){
            parent::__construct();
            $this->processarAcao();
        }

        public function lerBancoDados(){
            $pdo = conectar();
            $TABELA = 'lista_usuarios';

            $stmt = $pdo->prepare('SELECT * FROM ' . $TABELA);

            $stmt->execute();

            $this->dadosRecuperados = $stmt->fetchAll();

            if($this->dadosRecuperados){
                $this->adicionarColunaNaTela();
            }
        }
        

        private function adicionarColunaNaTela(){
            foreach ($this->dadosRecuperados as $key) {  
                $id = $key['id'];           
                $email = $key['email'];
                $user_type = $key['user_type'];
                $sobrenome = $key['lastName'];
                $nome = $key['firstName'];
                $user_type = $key['user_type'];
                $supervisor = $key['supervisor'];
                $telefone = $key['phone'];
                $empresa = $key['company'];
                $ultimoLogin = $key['lastLogin'];
                $usuarioBloqueado = $key['attemptsEmail'];

                $corBloqueado ?? '';

                $usuarioBloqueado < 3 ? $corBloqueado = 'notblocked' : $corBloqueado = 'blocked';
            
                $action = htmlspecialchars($_SERVER['PHP_SELF']);
                
                $actionEditar = $action . '?action=editar';
                $actionDesbloquear = $action . '?action=desbloquear';
                $actionDeletar = $action . '?action=deletar';

            echo "<tr>
                    <td>$user_type</td>
                    <td>$sobrenome</td>
                    <td>$nome</td>
                    <td>$supervisor</td>
                    <td>$telefone</td>
                    <td>$email</td>
                    <td>$empresa</td>
                    <td>$ultimoLogin</td>
                    <td><span class='ticket'>ATIVADO</span></td>
                    <td class='actions'>
                        <form method='post' action='$actionEditar'>
                            <input type='hidden' name='linha_id' value='$id'>
                            <button type='submit'>
                                <i class='fa-solid fa-pen-to-square'></i>
                            </button>
                        </form>
                        <form method='post' action='$actionDesbloquear'>
                            <input type='hidden' name='linha_id' value='$id'>
                            <button type='submit'>
                                <i class='$corBloqueado fa-solid fa-user-slash'></i>
                            </button>
                        </form>
                        <form method='post' action='$actionDeletar'>
                            <input type='hidden' name='linha_id' value='$id'>
                            <button type='submit'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                        </form>
                    </td>
                </tr>";

            }
        }
        public function processarAcao(){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['linha_id'])) {
                    $linha_id = $_POST['linha_id'];
                    $acao = $_GET['action'];
    
                    switch ($acao) {
                        case 'editar':
                            $this->editarUsuario($linha_id);
                            break;
                        case 'desbloquear':
                            $this->desbloquearUsuario($linha_id);
                            break;
                        case 'deletar':
                            $this->removerUsuario($linha_id);
                        break;
                    }
                }
            }
        }
        private function editarUsuario($id) {
            
            $this->mostrarModal();
            
            // abrir POPUP com formulario

            // enviar via submit 

            // fechar popUp

            // se der resultado certo alerta positivo

            // se der resultado errado alerta errado

        }
        
        private function desbloquearUsuario($id) {

            // popup certeza

            $pdo = conectar();

            $TABELA = 'lista_usuarios';

            $RESETAR_TENTATIVAS = 0;

            $stmt = $pdo->prepare("UPDATE $TABELA SET attemptsEmail = :attemptsEmail WHERE id = :id");
            $stmt->bindParam(':attemptsEmail', $RESETAR_TENTATIVAS);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            header("Refresh: 0");
        }
        
        private function removerUsuario($id) {

            // popup certeza
            
            $pdo = conectar();

            $TABELA = 'lista_usuarios';

            $stmt = $pdo->prepare("DELETE FROM $TABELA WHERE id = :id");
            $stmt->bindParam(':id', $id);

            $stmt->execute();
            
            header("Refresh: 0");
        }
        private function mostrarModal(){
           // code...!
        }
        
    }
    class AdminCreateUser extends Admin{
        protected $cargo;
        protected $empresa;
        protected $primeiroNome;
        protected $sobrenome;
        protected $genero;
        protected $funcionario;
        protected $supervisor;
        protected $usuarioExterno = 'Externo';
        protected $usuarioTipo;
        protected $password;
        protected $endereco;
        protected $cep;
        protected $municipio;
        protected $pais;
        protected $estado;
        protected $celular;
        protected $email;
        protected $usuarioHorarioCadastro;
        
        
        public function __construct(){
            parent::__construct();
        }
        public function pegarDadosFormulario(){
            $this->cargo = $_POST['cargo'];
            $this->empresa = $_POST['empresa'];
            $this->primeiroNome = $_POST['primeiroNome'];
            $this->sobrenome = $_POST['sobrenome'];
            $this->genero = $_POST['genero'];
            $this->funcionario = $_POST['funcionario'];
            $this->supervisor = $_POST['supervisor'];
            $this->usuarioTipo = $_POST['user_type'];
            $this->password = $_POST['password'];
            $this->endereco = $_POST['endereco'];
            $this->cep = $_POST['cep'];
            $this->municipio = $_POST['municipio'];
            $this->pais = $_POST['pais'];
            $this->estado = $_POST['estado'];
            $this->celular = $_POST['celular'];
            $this->email = $_POST['email'];
        }

        private function pegarHorarioAtual(){
            date_default_timezone_set('America/Sao_Paulo');
            $this->usuarioHorarioCadastro = date('Y-m-d H:i:s');
        }

        public function criarUserNoBancoDados(){
            $this->pegarHorarioAtual();

            $pdo = conectar();

            $TABELA = 'lista_usuarios';

            $stmt = $pdo->prepare("INSERT INTO $TABELA (
                `email`,
                `position`,
                `company`,
                `firstName`,
                `lastName`,
                `gender`,
                `isEmployee`,
                `supervisor`,
                `user_type`,
                `user_extern`,
                `password`,
                `address`,
                `zipCode`,
                `city`,
                `country`,
                `state`,
                `phone`,
                `time_registered`
            ) VALUES (
                :email,
                :position,
                :company,
                :firstName,
                :lastName,
                :gender,
                :isEmployee,
                :supervisor,
                :user_type,
                :user_extern,
                :password,
                :address,
                :zipCode,
                :city,
                :country,
                :state,
                :phone,
                :time_registered

            )");
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':position', $this->cargo);
            $stmt->bindParam(':company', $this->empresa);
            $stmt->bindParam(':firstName', $this->primeiroNome);
            $stmt->bindParam(':lastName', $this->sobrenome);
            $stmt->bindParam(':gender', $this->genero);
            $stmt->bindParam(':isEmployee', $this->funcionario);
            $stmt->bindParam(':supervisor', $this->supervisor);
            $stmt->bindParam(':user_type', $this->usuarioTipo);
            $stmt->bindParam(':user_extern', $this->usuarioExterno);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':address', $this->endereco);
            $stmt->bindParam(':zipCode', $this->cep);
            $stmt->bindParam(':city', $this->municipio);
            $stmt->bindParam(':country', $this->pais);
            $stmt->bindParam(':state', $this->estado);
            $stmt->bindParam(':phone', $this->celular);
            $stmt->bindParam(':time_registered', $this->usuarioHorarioCadastro);

            if ($stmt->execute()) {
                $this->mostrarPop = 'on';
                $this->corPop = 'green';
                $this->mensagemPop = 'Usuario criado com sucesso!';
                $this->mostrarPopup();
                
            } else {
                $this->mostrarPop = 'on';
                $this->corPop = 'red';
                $this->mensagemPop = 'Erro ao criar usuario.';
                $this->mostrarPopup();
                
            }
        }
        public function mostrarPopup(){
            $showPopUp = [$this->mostrarPop, $this->corPop,$this->mensagemPop];
            return $showPopUp;
        }
        
    }
?>