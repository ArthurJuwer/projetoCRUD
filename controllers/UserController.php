<?php 
    require_once '../../assets/php/conect.php';
    class User {
        protected $usuarioEmail;
        protected $mostrarPop;
        protected $corPop;
        protected $mensagemPop;
        protected $TABELA = 'lista_usuarios';

        public function __construct(){
            $this->obterEmailUsuarioLogado();
            $this->atualizarTentativasUsuario();
            $this->sairConta();
        }

        private function atualizarTentativasUsuario(){
            $pdo = conectar();

            $RESETAR_TENTATIVAS = 0;

            $stmt = $pdo->prepare("UPDATE $this->TABELA SET attemptsEmail = :attemptsEmail WHERE email = :email");
            $stmt->bindParam(':attemptsEmail', $RESETAR_TENTATIVAS);
            $stmt->bindParam(':email', $this->usuarioEmail);
            $stmt->execute();
        }

        private function obterEmailUsuarioLogado() {
            session_start();
            if (isset($_SESSION['email_usuario']) && $_SESSION['email_usuario'] != null) {
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
        private function sairConta(){
            if (isset($_POST['sair']) && $_POST['sair'] == 'sair') {
                session_start();
                $_SESSION['email_logado'] = null;
                $_SESSION['email_usuario'] = null;
                header('Location: ../../login.php');
                exit(); 
            } 
        }
        private function alertaLogin(){
            session_start();
            $_SESSION['mensagem_alerta'] = 'Logue na sua conta para acessar o painel';
            $_SESSION['mostrar_alerta'] = 'red on';
        }

        public function pegarEmailLogado() {
            return $this->usuarioEmail;
        }
        
    }

    class UserProfile extends User {
        protected $dadosFormulario = [];

        public function __construct() {
            parent::__construct(); 
            $this->recuperarDadosUsuario();
        }

        public function criarFormulario() {
            echo '<form action="' . $_SERVER["PHP_SELF"] . '" method="post">
                    <div class="row-form">
                        <label for="empresa">Empresa: </label>
                        <input type="text" name="empresa" value="'. htmlspecialchars($this->dadosFormulario['company'], ENT_QUOTES) .'">
                    </div>
                    <div class="row-form">
                        <label for="cargo">Cargo: </label>
                        <input type="text" name="cargo" value="'. htmlspecialchars($this->dadosFormulario['position'], ENT_QUOTES) .'">
                    </div>
                    <div class="row-form">
                        <label for="primeiroNome">Primeiro nome: </label>
                        <input type="text" name="primeiroNome" value="'. htmlspecialchars($this->dadosFormulario['firstName'], ENT_QUOTES) .'">
                    </div>
                    <div class="row-form">
                        <label for="sobrenome">Sobrenome: </label>
                        <input type="text" name="sobrenome" value="'. htmlspecialchars($this->dadosFormulario['lastName'], ENT_QUOTES) .'">
                    </div>
                    <div class="row-form">
                        <label for="isAdmin">Administrador do sistema: </label>
                        <div class="row-form-icon">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="isAdmin" disabled value="'. htmlspecialchars($this->dadosFormulario['user_type'], ENT_QUOTES) .'">
                        </div>
                    </div>
                    <div class="row-form">
                        <label for="genero">Gênero: </label>
                        <select name="genero">
                            <option value="Masculino"' . ($this->dadosFormulario['gender'] == 'Masculino' ? ' selected' : '') . '>Masculino</option>
                            <option value="Feminino"' . ($this->dadosFormulario['gender'] == 'Feminino' ? ' selected' : '') . '>Feminino</option>
                            <option value="Undefined"' . ($this->dadosFormulario['gender'] == 'Undefined' ? ' selected' : '') . '>Prefiro não informar</option>
                        </select>
                    </div>
                    <div class="row-form">
                        <label for="funcionario">Funcionário: </label>
                        <select name="funcionario">
                            <option value="isFuncionarioFalse"' . ($this->dadosFormulario['isEmployee'] == 'isFuncionarioFalse' ? ' selected' : '') . '>Não</option>
                            <option value="isFuncionarioTrue"' . ($this->dadosFormulario['isEmployee'] == 'isFuncionarioTrue' ? ' selected' : '') . '>Sim</option>
                        </select>
                    </div>
                    <div class="row-form">
                        <label for="supervisor">Supervisor: </label>
                        <select name="supervisor">
                            <option value="nao definido"' . ($this->dadosFormulario['supervisor'] == 'nao definido' ? ' selected' : '') . '>Não Definido</option>
                            <optgroup label="Grupo 1">
                                <option value="arthur"' . ($this->dadosFormulario['supervisor'] == 'arthur' ? ' selected' : '') . '>Arthur</option>
                                <option value="rodrigo"' . ($this->dadosFormulario['supervisor'] == 'rodrigo' ? ' selected' : '') . '>Rodrigo</option>
                            </optgroup>
                            <optgroup label="Grupo 2">
                                <option value="leonardo"' . ($this->dadosFormulario['supervisor'] == 'leonardo' ? ' selected' : '') . '>Leonardo</option>
                                <option value="eduardo"' . ($this->dadosFormulario['supervisor'] == 'eduardo' ? ' selected' : '') . '>Eduardo</option>
                            </optgroup> 
                        </select>
                    </div>
                    <div class="row-form">
                        <label for="user_extern">Usuário Externo? </label>
                        <input type="text" name="user_extern" disabled value="'. htmlspecialchars($this->dadosFormulario['user_extern'], ENT_QUOTES) .'">
                    </div>
                    <hr>
                    <div class="row-form">
                        <label for="password">Senha: </label>
                        <div class="row-form-image">
                            <img src="../../assets/images/eyeOpen.png" alt="showPassword" name="imagePassword">
                            <input type="password" name="password" value="'. htmlspecialchars($this->dadosFormulario['password'], ENT_QUOTES) .'">
                        </div>
                    </div>
                    <hr>
                    <div class="row-form">
                        <label for="endereco">Endereço: </label>
                        <textarea name="endereco">' . htmlspecialchars($this->dadosFormulario['address'], ENT_QUOTES) . '</textarea>
                    </div>
                    <div class="row-form">
                        <label for="cep">CEP: </label>
                        <input type="text" name="cep" value="'. htmlspecialchars($this->dadosFormulario['zipCode'], ENT_QUOTES) .'">
                    </div>
                    <div class="row-form">
                        <label for="municipio">Município: </label>
                        <input type="text" name="municipio" value="'. htmlspecialchars($this->dadosFormulario['city'], ENT_QUOTES) .'">
                    </div>
                    <div class="row-form">
                        <label for="pais">País: </label>
                        <div class="row-form-icon">
                            <i class="fa-solid fa-earth-americas"></i>
                            <input type="text" name="pais" value="'. htmlspecialchars($this->dadosFormulario['country'], ENT_QUOTES) .'">
                        </div>
                    </div>
                    <div class="row-form">
                        <label for="estado">Estado: </label>
                        <div class="row-form-icon">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <input type="text" name="estado" value="'. htmlspecialchars($this->dadosFormulario['state'], ENT_QUOTES) .'">
                        </div>
                    </div>
                    <div class="row-form">
                        <label for="celular">Celular: </label>
                        <div class="row-form-icon">
                            <i class="fa-solid fa-phone"></i>
                            <input type="tel" name="celular" value="'. htmlspecialchars($this->dadosFormulario['phone'], ENT_QUOTES) .'">
                        </div>
                    </div>
                    <div class="row-form">
                        <label for="email">Email: </label>
                        <div class="row-form-icon">
                            <i class="fa-solid fa-at"></i>
                            <input type="text" name="email" disabled value="'. htmlspecialchars($this->dadosFormulario['email'], ENT_QUOTES) .'">
                        </div>
                    </div>
                    <div class="end-form">
                        <input type="submit" value="Atualizar">
                    </div>
                    <div class="alert-message ' . $this->mostrarPop . ' ' . $this->corPop . ' " >
                        <p>' . $this->mensagemPop . '</p>
                    </div>
                </form>';
        }

        public function recuperarDadosUsuario(){
            $pdo = conectar();
            $stmt = $pdo->prepare("SELECT * FROM $this->TABELA WHERE email = :email");
            $stmt->bindParam(':email', $this->usuarioEmail);
            $stmt->execute();
            $linha = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->dadosFormulario = [
                'firstName' => $linha['firstName'] ?? '',
                'lastName' => $linha['lastName'] ?? '',
                'position' => $linha['position'] ?? '',
                'company' => $linha['company'] ?? '',
                'user_type' => $linha['user_type'] ?? '',
                'gender' => $linha['gender'] ?? '',
                'isEmployee' => $linha['isEmployee'] ?? '',
                'supervisor' => $linha['supervisor'] ?? '',
                'user_extern' => $linha['user_extern'] ?? '',
                'password' => $linha['password'] ?? '',
                'address' => $linha['address'] ?? '',
                'zipCode' => $linha['zipCode'] ?? '',
                'city' => $linha['city'] ?? '',
                'country' => $linha['country'] ?? '',
                'state' => $linha['state'] ?? '',
                'phone' => $linha['phone'] ?? '',
                'email' => $linha['email'] ?? ''
            ];
        }

        public function obterDadosFormulario() {
            $this->dadosFormulario['company'] = $_POST['empresa'] ?? '';
            $this->dadosFormulario['position'] = $_POST['cargo'] ?? '';
            $this->dadosFormulario['firstName'] = $_POST['primeiroNome'] ?? '';
            $this->dadosFormulario['lastName'] = $_POST['sobrenome'] ?? '';
            $this->dadosFormulario['gender'] = $_POST['genero'] ?? '';
            $this->dadosFormulario['isEmployee'] = $_POST['funcionario'] ?? '';
            $this->dadosFormulario['supervisor'] = $_POST['supervisor'] ?? '';
            $this->dadosFormulario['password'] = $_POST['password'] ?? '';
            $this->dadosFormulario['address'] = $_POST['endereco'] ?? '';
            $this->dadosFormulario['zipCode'] = $_POST['cep'] ?? '';
            $this->dadosFormulario['city'] = $_POST['municipio'] ?? '';
            $this->dadosFormulario['country'] = $_POST['pais'] ?? '';
            $this->dadosFormulario['state'] = $_POST['estado'] ?? '';
            $this->dadosFormulario['phone'] = $_POST['celular'] ?? '';
        }

        public function atualizarBancoDados() {
            $pdo = conectar();
            $stmt = $pdo->prepare("UPDATE lista_usuarios SET
                company = :company,
                position = :position,
                firstName = :firstName,
                lastName = :lastName,
                gender = :gender,
                isEmployee = :isEmployee,
                supervisor = :supervisor,
                user_extern = :user_extern,
                password = :password,
                address = :address,
                zipCode = :zipCode,
                city = :city,
                country = :country,
                state = :state,
                phone = :phone
                WHERE email = :email");
            $stmt->bindParam(':company', $this->dadosFormulario['company']);
            $stmt->bindParam(':position', $this->dadosFormulario['position']);
            $stmt->bindParam(':firstName', $this->dadosFormulario['firstName']);
            $stmt->bindParam(':lastName', $this->dadosFormulario['lastName']);
            $stmt->bindParam(':gender', $this->dadosFormulario['gender']);
            $stmt->bindParam(':isEmployee', $this->dadosFormulario['isEmployee']);
            $stmt->bindParam(':supervisor', $this->dadosFormulario['supervisor']);
            $stmt->bindParam(':user_extern', $this->dadosFormulario['user_extern']);
            $stmt->bindParam(':password', $this->dadosFormulario['password']);
            $stmt->bindParam(':address', $this->dadosFormulario['address']);
            $stmt->bindParam(':zipCode', $this->dadosFormulario['zipCode']);
            $stmt->bindParam(':city', $this->dadosFormulario['city']);
            $stmt->bindParam(':country', $this->dadosFormulario['country']);
            $stmt->bindParam(':state', $this->dadosFormulario['state']);
            $stmt->bindParam(':phone', $this->dadosFormulario['phone']);
            $stmt->bindParam(':email', $this->dadosFormulario['email']);

            if ($stmt->execute()) {
                $this->mostrarPop = 'on';
                $this->corPop = 'green';
                $this->mensagemPop = 'Dados atualizados com sucesso!';
                
            } else {
                $this->mostrarPop = 'on';
                $this->corPop = 'red';
                $this->mensagemPop = 'Erro ao atualizar dados.';
            }
        }
    }
?>