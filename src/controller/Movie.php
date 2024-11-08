<?php
require_once '../model/Movie.php';

class MovieController
{
    private $movie;

    public function __construct($db)
    {
        $this->movie = new Movie($db);
    }

    public function list()
    {
        $movie = $this->movie->list();
        echo json_encode($movie);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->nome) && isset($data->descricao)) {
            try {
                $this->movie->create($data->nome, $data->descricao);

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

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($id) && isset($data->nome) && isset($data->descricao) && isset($data->rating)) {
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

    public function delete($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($id)) {
            try {
                $count = $this->movie->delete($data->id);

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
}