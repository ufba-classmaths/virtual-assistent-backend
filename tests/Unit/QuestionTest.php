<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    /**
     * A basic unit test example.
     * @dataProvider questionProvider
     * @return void
     */
    public function test_index($questionList){

        $questionController = $this->createMock(QuestionController::class);

        $questionsRepository->method('index')
            ->willReturn($questionList);
        dd($questionsRepository);
         $this->assertCount(3, $questionList);
    }



    public function questionProvider()
    {
        return [ "getAllQuestions"=>[
                    "questionList"=>[

                [
                    "id"=> 1,
                    "description"=> "Criação do Instituto de Computação",
                    "answer"=> "O Instituto de Computação (IC) da UFBA foi criado em 18 de Junho de 2021",
                    "parents"=> [
                        "Institucional",
                        "Sobre o IC"
                    ]
                    ],
                [
                    "id"=> 2,
                    "description"=> "Resolução que criou o instituto de computação",
                    "answer"=> "Resolucao 05.2021 do Conselho Universitario da UFBA",
                    "parents"=> [
                        "Institucional",
                        "Sobre o IC"
                    ]
                    ],
                [
                    "id"=> 3,
                    "description"=> "Departamentos que fazem parte do Instituto de Computação",
                    "answer"=> "Departamento de Ciência da Computação (DCC) e Departamento de Computacao Interdisciplinar (DCI)",
                    "parents"=> [
                        "Institucional",
                        "Sobre o IC"
                    ]
                    ],

            ]
        ]


        ];
    }
}
