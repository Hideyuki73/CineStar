<?php
require_once '../model/User.php';

class UserController
{
    private $user;

    private static $INSTANCE;

    public static function getInstance(){
        if(!isset(self::$INSTANCE)){
            self::$INSTANCE = new UserController();
        }
        return self::$INSTANCE;
    }
    public function __construct()
    {
        $this->user = new User(Database::getInstance());
    }

    public function list()
    {
        $users = $this->user->list();
        echo json_encode($users);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->nickname) && isset($data->email) && isset($data->senha)) {
            try {
                $this->user->create($data->nickname, $data->email, $data->senha);

                http_response_code(201);
                echo json_encode(["message" => "Usuário criado com sucesso."]);
            } catch (\Throwable $th) {
                print_r($th);
                http_response_code(500);
                echo json_encode(["message" => "Erro ao criar o usuário."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function getById($id)
    {
        if (isset($id)) {
            try {
                $user = $this->user->getById($id);
                if ($user) {
                    echo json_encode($user);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Usuário não encontrado."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar o usuário."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function getByEmail($email){
        if (isset($email)) {
            try {
                $user = $this->user->getByEmail($email);
                if ($user) {
                    echo json_encode($user);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Usuário não encontrado."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar o usuário."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id) && isset($data->nickname) && isset($data->email) && isset($data->senha)) {
            try {
                $count = $this->user->update($data->id, $data->nickname, $data->email, $data->senha);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Usuário atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar o usuário."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar o usuário."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id)) {
            try {
                $count = $this->user->delete($data->id);

                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Usuário deletado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar o usuário."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar o usuário."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function login()
    {
        session_start();
    
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->email) && isset($data->senha)) {
            $email = $data->email;
            $senha = $data->senha;
    
            $user = $this->user->getByEmail($email);
    
            if ($user &&  $user['senha'] == $senha) {
                $_SESSION['user_id'] = $user['id']; 
                echo json_encode([
                    "status" => "success",
                    "message" => "Login realizado com sucesso.",
                    "user_id" => $user['id']
                ]);
            } else {
                http_response_code(401);
                echo json_encode(["status" => "error", "message" => "Email ou senha incorretos."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Dados incompletos."]);
        }
    }
    
}