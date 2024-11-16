<?php

require_once '../model/Movie.php';

class MovieController
{
    private $movie;

    private static $INSTANCE;

    public static function getInstance(){
        if(!isset(self::$INSTANCE)){
            self::$INSTANCE = new MovieController();
        }
        return self::$INSTANCE;
    }
    public function __construct()
    {
        $this->movie = new Movie(Database::getInstance());
    }

    public function list()
    {
        $movie = $this->movie->list();
        echo json_encode($movie);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->nome) && isset($data->descricao) && isset($data->rating)) {
            try {
                $this->movie->create($data->nome, $data->descricao, $data->rating, $data->id_users);

                http_response_code(201);
                echo json_encode(["message" => "Filme criado com sucesso."]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao criar o filme."]);
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
                $movie = $this->movie->getById($id);
                if ($movie) {
                    echo json_encode($movie);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Filme não encontrado."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar o filme."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id) && isset($data->nome) && isset($data->descricao) && isset($data->rating)) {
            try {
                $count = $this->movie->update($data->id, $data->nome, $data->descricao, $data->rating);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Filme atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar o filme."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar o filme."]);
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
                $count = $this->movie->delete($data->id);

                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Filme deletado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar o Filme."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar o Filme."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}