<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuestionRequest;
use App\Traits\ApiResponser;
use App\Models\Question;
use Throwable;

class AuthController extends Controller
{

    use ApiResponser;
    public function createQuestion(CreateQuestionRequest $questionRequest)
    {
        try {
            Question::create([
                "description" => $questionRequest["description"],
                "answare" => $questionRequest["answare"],
                "topic_id" => $questionRequest["topic_id"]
            ]);
            return $this->success('Registro criado com sucesso.');
        } catch (Throwable $e) {
            return $this->error('Erro: ' + $e, 404);
        }
    }
}


//CommitTestDaniel