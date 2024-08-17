<?php 
class Admin{
    protected $emailUser; 

    public function __construct(){
        $this->obterEmailAdmin();
    }

    private function obterEmailAdmin(){
        session_start();
        $this->emailUser = $_SESSION['email_usuario'];

    }

    public function getEmailLogado(){
        return $this->emailUser;
    }
}

class AdminReadDataBase extends Admin{
    protected $dadosRecuperados;
    protected $valorlinha;

    public function __construct(){
        parent::__construct();
    }

    public function lerBancoDados(){
        include '../../assets/php/conect.php';

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
            $email = $key['email'];
            $user_type = $key['user_type'];
            $sobrenome = $key['lastName'];
            $nome = $key['firstName'];
            $user_type = $key['user_type'];
            $supervisor = $key['supervisor'];
            $telefone = $key['phone'];
            echo "<tr>
                <td>$user_type</td>
                <td>$sobrenome</td>
                <td>$nome</td>
                <td>$supervisor</td>
                <td>$telefone</td>
                <td>$email</td>
                <td></td>
                <td></td>
                <td><span class='ticket'>ATIVADO</span></td>
            </tr>";
        }
    }
}
class AdminCreateUser extends Admin{
    protected $cargo;
    protected $primeiroNome;
    protected $sobrenome;
    protected $genero;
    protected $funcionario;
    protected $supervisor;
    protected $password;
    protected $endereco;
    protected $cep;
    protected $municipio;
    protected $pais;
    protected $estado;
    protected $celular;
    protected $email;
    protected $userTimeRegistered;
    
    public function __construct(){
        parent::__construct();
    }
    public function pegarDadosFormulario(){
        $this->cargo = $_POST['cargo'];
        $this->primeiroNome = $_POST['primeiroNome'];
        $this->sobrenome = $_POST['sobrenome'];
        $this->genero = $_POST['genero'];
        $this->funcionario = $_POST['funcionario'];
        $this->supervisor = $_POST['supervisor'];
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
        $this->userTimeRegistered = date('d/m/Y H:i:s');
    }

    public function criarUserNoBancoDados(){
        include '../../assets/php/conect.php';
        $this->pegarHorarioAtual();

        $pdo = conectar();

        $TABELA = 'lista_usuarios';

        $stmt = $pdo->prepare($sql = "INSERT INTO $TABELA (
            `email`,
            `position`,
            `firstName`,
            `lastName`,
            `gender`,
            `isEmployee`,
            `supervisor`,
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
            :firstName,
            :lastName,
            :gender,
            :isEmployee,
            :supervisor,
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
        $stmt->bindParam(':firstName', $this->primeiroNome);
        $stmt->bindParam(':lastName', $this->sobrenome);
        $stmt->bindParam(':gender', $this->genero);
        $stmt->bindParam(':isEmployee', $this->funcionario);
        $stmt->bindParam(':supervisor', $this->supervisor);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':address', $this->endereco);
        $stmt->bindParam(':zipCode', $this->cep);
        $stmt->bindParam(':city', $this->municipio);
        $stmt->bindParam(':country', $this->pais);
        $stmt->bindParam(':state', $this->estado);
        $stmt->bindParam(':phone', $this->celular);
        $stmt->bindParam(':time_registered', $this->userTimeRegistered);

        if($stmt->execute()){
            echo "usuario criado";
        } else {
            echo "Erro";
        }
    }
}
?>