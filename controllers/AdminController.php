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

    class AdminReadDataBase extends Admin {
        protected $dadosRecuperados;
        protected $valorlinha;
        protected $dadosRecuperadosEditar;
        protected $dadosFormulario = [];
    
        public function __construct() {
            parent::__construct();
            $this->processarAcao();
        }
    
        public function lerBancoDados() {
            $pdo = conectar();
            $TABELA = 'lista_usuarios';
    
            $stmt = $pdo->prepare('SELECT * FROM ' . $TABELA);
            $stmt->execute();
    
            $this->dadosRecuperados = $stmt->fetchAll();
    
            if ($this->dadosRecuperados) {
                $this->adicionarColunaNaTela();
            }
        }
        public function criarPesquisar(){
            
            $action = htmlspecialchars($_SERVER['PHP_SELF']);

            echo '
            <form action="'.$action . '" method="get">
                <div class="input-field">
                    <input type="search" name="search" id="search" placeholder="Pesquise pelo nome do usuario...">
                    <div class="input-options-field">
                        <select name="filter">
                            <option value="user_type">Tipo de Usuário</option>
                            <option value="lastName">Sobrenome</option>
                            <option value="firstName">Nome</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="phone">Telefone</option>
                            <option value="email">E-mail</option>
                            <option value="company">Empresa</option>
                            <option value="lastLogin">Último Login</option>
                        </select>
                        <i class="fa-solid fa-filter"></i>
                    </div>
                    <div class="input-submit-field">
                        <input type="submit" value="">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
            </form>';

        }
        public function lerPesquisa() {
            if (isset($_GET['search'])) {
                $pesquisa = $_GET['search'];
                $filtro = $_GET['filter'];
                
                $pdo = conectar();
                $TABELA = 'lista_usuarios';
                
                $stmt = $pdo->prepare("SELECT * FROM $TABELA WHERE $filtro LIKE :filtro");
                $termoPesquisa = '%' . trim($pesquisa) . '%';
                $stmt->bindParam(":filtro", $termoPesquisa);
                $stmt->execute();
        
                $this->dadosRecuperados = $stmt->fetchAll();
        
                if ($this->dadosRecuperados) {
                    if($pesquisa !== ''){
                        echo "<p class='titleSearch'>Mostrando resultados para '$pesquisa' no filtro '$filtro'</p>";
                    }
                    $this->adicionarColunaNaTela();
                    
                } else {
                    echo "<p class='titleSearch'>Nenhum resultado encontrado para '$pesquisa' no filtro '$filtro'</p>";
                }
            } else {
                $this->lerBancoDados();
            }
        }
        private function adicionarColunaNaTela() {
            foreach ($this->dadosRecuperados as $key) {
                $id = $key['id'];           
                $email = $key['email'];
                $user_type = $key['user_type'];
                $sobrenome = $key['lastName'];
                $nome = $key['firstName'];
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
    
        public function processarAcao() {
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
                } else if (isset($_POST['action']) && $_POST['action'] == 'confirmar_edicao') {
                    $id = $_POST['id']; 
                    $this->obterDadosFormulario();
                    $this->atualizarBancoDados($id);
                }
            }
        }
    
        private function editarUsuario($id) {
            $pdo = conectar();
            $TABELA = 'lista_usuarios';
    
            $stmt = $pdo->prepare('SELECT * FROM ' . $TABELA . ' WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
    
            $this->dadosRecuperadosEditar = $stmt->fetchAll();
            foreach ($this->dadosRecuperadosEditar as $key) {
                $user_type = $key['user_type'];
                $sobrenome = $key['lastName'];
                $nome = $key['firstName'];
                $supervisor = $key['supervisor'];
                $telefone = $key['phone'];
                $email = $key['email'];
                $empresa = $key['company'];
                $ultimoLogin = $key['lastLogin'];
            }
            $this->mostrarModal($id, $user_type, $sobrenome, $nome, $supervisor, $telefone, $email, $empresa, $ultimoLogin);
        }
    
        private function desbloquearUsuario($id) {
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
            $pdo = conectar();
            $TABELA = 'lista_usuarios';
    
            $stmt = $pdo->prepare("DELETE FROM $TABELA WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            header("Refresh: 0");
        }
    
        private function mostrarModal($id, $user_type, $sobrenome, $nome, $supervisor, $telefone, $email, $empresa, $ultimoLogin) {
            $action = htmlspecialchars($_SERVER['PHP_SELF']);
            echo '
            <style>
            .popup-content {
                z-index: 1000;
                position: fixed;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                width: 80%;
                max-width: 1200px; /* Ajuste a largura conforme necessário */
                box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .popup-content h2 {
                width: 100%;
                margin-bottom: 20px;
                font-size: 18px;
                color: #333;
                text-align: center;
            }

            .form-row {
                display: flex;
                flex-wrap: wrap;
                width: 100%;
                gap: 1rem; 
                justify-content: space-between;
            }

            .form-group {
                flex: 1 1 20%;
                margin: 5px;
            }

            .popup-content label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
                color: #555;
            }

            .popup-content input[type="text"],
            .popup-content input[type="email"],
            .popup-content input[type="password"] {
                width: 100%;
                padding: 0.5rem;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .popup-content .button-container {
                width: 100%;
                text-align: center;
                margin-top: 1.2rem;
            }

            .popup-content .confirm-btn, .popup-content .cancel-btn {
                margin: 0.5rem;
                padding: 0.5rem 1rem;
                width: 120px; /* Largura fixa para os botões */
                cursor: pointer;
                color: white;
                border: none;
                border-radius: 4px;
            }

            .popup-content .confirm-btn {
                background-color: #4CAF50;  
            }
            .popup-content .cancel-btn {
                background-color: #f44336;
            }
        </style>
            <div class="popup-content">
                <h2>Editar Usuário</h2>
                <form method="post" action="' . $action . '">
                    <input type="hidden" name="id" value="' . htmlspecialchars($id) . '">
                    <input type="hidden" name="action" value="confirmar_edicao">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="user_type">Iniciar Sessão:</label>
                            <input type="text" id="user_type" name="user_type" value="' . htmlspecialchars($user_type) . '">
                        </div>
                        <div class="form-group">
                            <label for="sobrenome">Sobrenome:</label>
                            <input type="text" id="sobrenome" name="sobrenome" value="' . htmlspecialchars($sobrenome) . '">
                        </div>
                        <div class="form-group">
                            <label for="primeiroNome">Primeiro Nome:</label>
                            <input type="text" id="primeiroNome" name="primeiroNome" value="' . htmlspecialchars($nome) . '">
                        </div>
                        <div class="form-group">
                            <label for="supervisor">Supervisor:</label>
                            <input type="text" id="supervisor" name="supervisor" value="' . htmlspecialchars($supervisor) . '">
                        </div>
                        <div class="form-group">
                            <label for="celular">Celular:</label>
                            <input type="text" id="celular" name="celular" value="' . htmlspecialchars($telefone) . '">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" id="email" name="email" value="' . htmlspecialchars($email) . '">
                        </div>
                        <div class="form-group">
                            <label for="empresa">Empresa:</label>
                            <input type="text" id="empresa" name="empresa" value="' . htmlspecialchars($empresa) . '">
                        </div>
                        <div class="form-group">
                            <label for="ultimoLogin">Último Login:</label>
                            <input type="text" id="ultimoLogin" name="ultimoLogin" value="' . htmlspecialchars($ultimoLogin) . '">
                        </div>
                    </div>
                    <div class="button-container">
                        <button id="confirmBtn" class="confirm-btn" type="submit">Confirmar</button>
                        <button id="cancelBtn" class="cancel-btn" type="button" onclick="closeModal()">Cancelar</button>
                    </div>
                </form>
            </div>
            <script>
                function closeModal() {
                    // Função para fechar o modal
                    document.querySelector(".popup-content").style.display = "none";
                }
            </script>
            ';
        }
    
    
        private function obterDadosFormulario() {
            $this->dadosFormulario['user_type'] = $_POST['user_type'] ?? '';
            $this->dadosFormulario['company'] = $_POST['empresa'] ?? '';
            $this->dadosFormulario['firstName'] = $_POST['primeiroNome'] ?? '';
            $this->dadosFormulario['lastName'] = $_POST['sobrenome'] ?? '';
            $this->dadosFormulario['supervisor'] = $_POST['supervisor'] ?? '';
            $this->dadosFormulario['phone'] = $_POST['celular'] ?? '';
            $this->dadosFormulario['email'] = $_POST['email'] ?? '';
        }
    
        private function atualizarBancoDados($id) {
            $pdo = conectar();
            $stmt = $pdo->prepare("UPDATE `lista_usuarios` SET
                user_type = :user_type,
                company = :company,
                firstName = :firstName,
                lastName = :lastName,
                supervisor = :supervisor,
                phone = :phone,
                email = :email
                WHERE id = :id");
    
            $stmt->bindParam(':user_type', $this->dadosFormulario['user_type']);
            $stmt->bindParam(':company', $this->dadosFormulario['company']);
            $stmt->bindParam(':firstName', $this->dadosFormulario['firstName']);
            $stmt->bindParam(':lastName', $this->dadosFormulario['lastName']);
            $stmt->bindParam(':supervisor', $this->dadosFormulario['supervisor']);
            $stmt->bindParam(':phone', $this->dadosFormulario['phone']);
            $stmt->bindParam(':email', $this->dadosFormulario['email']);
            $stmt->bindParam(':id', $id);
    
            $stmt->execute();
            header("Refresh: 0");
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