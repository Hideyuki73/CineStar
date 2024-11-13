<?php
require_once '../model/Rating.php';

class RatingController
{
    private $rating;

    public function __construct($db)
    {
        $this->rating = new Rating($db);
    }

    public function list()
    {
        $rating = $this->rating->list();
        echo json_encode($rating);
    }

    public function create($rating, $userId, $movieId)
    {
        if (isset($rating) && isset($userId) && isset($movieId)) {
            try {
                $this->rating->create($rating, $userId, $movieId);
    
                http_response_code(201);
                echo json_encode(["message" => "Avaliação criada com sucesso."]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao criar a avaliação."]);
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
                $rating = $this->rating->getById($id);
                if ($rating) {
                    echo json_encode($rating);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Avaliacao não encontrado."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar o Avaliacao."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($id) && isset($data->rating)) {
            try {
                $count = $this->rating->update($data->id, $data->rating);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Avaliacao atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar a Avaliacao."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar a Avaliacao."]);
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
                $count = $this->rating->delete($data->id);

                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Avaliacao deletada com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar a Avaliacao."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar a Avaliacao."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}