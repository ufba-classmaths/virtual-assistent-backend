<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Traits\ApiResponser;
use App\Models\Question;
use Throwable;

class QuestionController extends Controller
{

    use ApiResponser;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Question::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\QuestionRequest  $questionRequest
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $questionRequest)
    {
        try {
            Question::create([
                "description" => $questionRequest["description"],
                "answare" => $questionRequest["answare"],
                "topic_id" => $questionRequest["topic_id"]
            ]);
            return $this->success('Registro criado com sucesso.');
        } catch (Throwable $e) {
            return $this->error('Erro: ' + $e, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\QuestionRequest  $questionRequest
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $questionRequest, Question $question)
    {
        if ($question) {
            try {
                $question->description = $questionRequest->input('description');

                $question->answare = $questionRequest->input('answare');

                $question->topic_id = $questionRequest->input('topic_id');

                $question->update();
                return $this->success('Registro alterado com sucesso.');
            } catch (Throwable $e) {
                return $this->error('Erro: ' + $e, 500);
            }
        } else
            return $this->error('Erro: Registro não encontrado.', 404);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        if ($question) {
            try {
                $question->delete();
                return $this->success('Registro deletado com sucesso.');
            } catch (Throwable $e) {
                return $this->error('Erro: ' + $e, 500);
            }
        } else
            return $this->error('Erro: Registro não encontrado.', 404);
    }
}


//CommitTestDaniel
